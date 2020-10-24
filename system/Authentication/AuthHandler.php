<?php

namespace System\Authentication;

use System\Authentication\Interfaces\CommonInterface;
use Session;
use Db;
use System\Validator\Validate\Validator;

/**
 * AuthHandler
 * @package System\Authentication
 */
class AuthHandler implements CommonInterface
{
        
    /**
     * data
     *
     * @var array
     */
    private $data = [];
    
    /**
     * table
     *
     * @var mixed
     */
    private $table;
    
    /**
     * dataFrom
     *
     * @var mixed
     */
    private $dataFrom;
    
    /**
     * localUsers
     *
     * @var array
     */
    private $localUsers = [];
    
    /**
     * searches
     *
     * @var array
     */
    private $searches = [];
    
    /**
     * errors
     *
     * @var array
     */
    private $errors = [];
    
    /**
     * supplement
     *
     * @var bool
     */
    private $supplement = true;
    
    /**
     * __construct
     *
     * @param  mixed $data
     * @param  mixed $table
     * @param  mixed $dataFrom
     * @param  mixed $localUsers
     * @return void
     */
    public function __construct(array $data, ?string $table, string $dataFrom, array $localUsers = [], array $searches)
    {
        
        $this->data = $data;
        $this->table = $table;
        $this->dataFrom = $dataFrom;
        $this->localUsers = $localUsers;
        $this->searches = $searches;

    }
    
    /**
     * searchLocalUsers
     *
     * @return void
     */
    private function searchLocalUsers()
    {

        $where = $this->searches['fields'];
        $as = $this->searches['comparison'];
        $users = $this->localUsers;

        $dataUser = [];
        $inputSuperKey = null;

        if(count($users) > 0)
        {
            foreach($users as $key => $user)
            {
                
                $inputSuperKey = null;
                $superKey = null;

                foreach($where as $k => $field)
                {
                    $superKey .= $field.'='.$user[$field].'&';
                    $inputSuperKey .= $field.'='.$as[$k].'&';
                }

                $dataUser[substr($superKey, 0, -1)] = $user;
            }
        }

        $inputSuperKey = substr($inputSuperKey, 0, -1);

        return array_key_exists($inputSuperKey, $dataUser) ? $dataUser[$inputSuperKey] : [];
        
    }
        
    /**
     * existsUser
     *
     * @return void
     */
    private function existsUser():array
    {

        switch($this->dataFrom)
        {
            case 'db':
                $dataUser = $this->searchDbUsers();
                break;
            case 'array': 
                $dataUser = $this->searchLocalUsers();
                break;
        }

        count($dataUser) < 1 ? $this->errors['user_dont_exists'] = 'Неверный логин или пароль.' : true;

        return $dataUser;

    }
        
    /**
     * searchDbUsers
     *
     * @return void
     */
    private function searchDbUsers()
    {

        $where = $this->searches['fields'];
        $as = $this->searches['comparison'];

        $fields = null;

        foreach($where as $numWhere => $keyName)
        {
            $fields .= $keyName.' = ? AND ';
        }

        $fields = substr($fields, 0, -5);

        $result = Db::getAll('SELECT * FROM '.$this->table.' WHERE '.$fields, $as);

        return $result;

    }
        
    /**
     * handlerValidation
     *
     * @return void
     */
    private function handlerValidation()
    {

        $validation = new Validator();

        foreach($this->data as $nameInput => $validate)
        {
            if($validate['required'] === false && !empty($validate['data']) || ($validate['required'] === true))
            {
                $validation = $validation->field($nameInput, $validate['data'])->with($nameInput, function($validator) use ($validate) {
                    if(count($validate['rules']) > 0)
                    {
                        foreach($validate['rules'] as $k => $rule)
                        {
                            if(array_key_exists($k, $validate['messages']))
                            {
                                $validator->validation($rule)
                                    ->setMessage($validate['messages'][$k]);
                            }
                            else {
                                $validator->validation($rule);
                            }
                        }
                    }
                });
            }
        }

        $validation->make();

        $this->errors += $validation->getErrors();

        return $validation->validated;

    }
    
    /**
     * $callback - анонимная функция, которая будет вызвана, если будут какие либо ошибки
     * Данный метод должен быть вызван, после метода authorize()
     * Принимает аргумент: $this->errors - массив ошибок
     * 
     * proccessErrors
     *
     * @param  mixed $callback
     * @return void
     */
    public function proccessErrors(callable $callback)
    {

        return call_user_func_array($callback, [$this->errors]);

    }
    
    /**
     * $callback - анонимная функция, которая выполнится перед вызовом метода authorize(), должна возврощать true|false
     * Данный метод вызывать перед методом authorize()
     * Принимает аргумент: $this - обЪект данного класса
     * 
     * supplement
     *
     * @param  mixed $callback
     * @return bool
     */
    public function supplement(callable $callback)
    {

        $this->supplement = call_user_func_array($callback, [$this]);

        return $this;

    }
    
    /**
     * $callback - анонимная функция, которая выполнится, если нет не каких ошибок. 
     * Принимает аргумент: $data - данные пользователя, $this - обЪект данного класса
     * 
     * authorize
     *
     * @param  mixed $callback
     * @return void
     */
    public function authorize(callable $callback)
    {

        if($this->supplement === true && $this->handlerValidation() === true && count($this->errors) < 1 && count($this->existsUser()) > 0)
        {
            call_user_func_array($callback, [$this->existsUser(), $this]);
        }

        return $this;

    }    

}