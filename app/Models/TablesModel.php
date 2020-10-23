<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use FastDB\ComponentsClasses\ComponentDefaults;
use FastDB\ComponentsClasses\ComponentTypes;
use Store;
use Flash;
use Validator;
use Date;
use Response;
use Redirector;
use Common;
use Random;

/**
 * DatabaseModel
 * @package System\Codememory
 */
class TablesModel extends RegisterService
{
        
    /**
     * regexDbname
     *
     * @var string
     */
    private $regexTablename = '/^[a-z0-9\-\_\.]+$/i';

    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;
    
    /**
     * create
     *
     * @var mixed
     */
    private $create;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();
        $this->conf = new ConfigurationRepository();
        $this->common = $this->model->load('Common');
        $this->create = $this->model->load('CreateFiles');
        $this->defaults = new ComponentDefaults($this->conf->getFullServer('server-dir'), $this->conf->getUsername(), $this->request->get('dbname'), $this->request->get('table'));
        $this->types = new ComponentTypes($this->conf->getFullServer('server-dir'), $this->conf->getUsername(), $this->request->get('dbname'), $this->request->get('table'));

    }
        
    /**
     * getInfo
     *
     * @param  mixed $dbname
     * @param  mixed $tablename
     * @return void
     */
    public function getInfo(string $dbname, string $tablename)
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), 'Databases/'.$this->getUsername().'/database='.$dbname.'/Tables/table='.$tablename.'/');
        $infoTable = Response::jsonToArray(Store::getApi($path.'data.fd'));
        $data = [
            'size' => Store::completeSize($path),
            'stat' => $infoTable['statistics'],
            'data' => $infoTable['data']
        ];

        return $data;

    }

    /**
     * existsTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function existsTable(string $dbname, string $table)
    {

        $dbModel = $this->model->load('Database');
        $databases = $dbModel->listWithTables();

        if(array_key_exists($dbname, $databases))
        {
            $tables = array_combine($databases[$dbname], $databases[$dbname]);

            return array_key_exists($table, $tables);
        }

        return false;

    }

    /**
     * getError
     *
     * @param  mixed $error
     * @return string
     */
    private function getError(string $error):string
    {

        $errors = [
            'column_is_empty'             => 'Заполните хотя бы одну колонку.',
            'invalid_name_column'         => 'Некорректно задано имя колонки.',
            'invalid_length'              => 'Длина должна быть типа integer',
            'invalid_type'                => 'Некорректный тип колонки',
            'invalid_defult'              => 'Некорректно задано значение по умолчанию',
            'invalid_charset'             => 'Некорректно выбрана кодировка',
            'min_symbol_table_name'       => 'Название таблицы не должно быть меньше 4-ох символов',
            'max_symbol_table_name'       => 'Название таблицы не должно превышать 20 символов',
            'invalid_table_name'          => 'Некорректно задано имя таблицы',
            'table_exists'                => 'Таблица %s в БД %s уже существует',
            'success_create_table'        => 'Таблица Успешно создана',
            'successfull_delete_table'    => 'Таблицу %s успешно удалена.',
            'move_table_redirect'         => 'Редирект в таблицу %s',
            'settings_table_success_save' => 'Настройки таблицы успешно сохранены.',
            'successfull_cleans_table'    => 'Таблица очищена.',
            'column_name_register'        => 'Имя %s является зарегестированным словом.',
            'success_edit_data_table'     => 'Запись обновлена.',
            'success_edit_structure'      => 'Структура Таблицы успешно обновлена.'
        ];

        if($this->request->get('json')) echo Response::arrayToJson(['response' => $errors[$key]]);

        return $errors[$error];

    }
        
    /**
     * getErrorToJson
     *
     * @param  mixed $status
     * @param  mixed $key
     * @param  mixed $add
     * @return void
     */
    private function getErrorToJson($status, $key, array $add = [])
    {
        
        $data = [
            'status'  => $status,
            'message' => $this->getError($key)
        ];

        if(count($add) > 0) {
            foreach($add as $k => $v)
            {
                $data[$k] = $v;
            }
        }

        return Response::arrayToJson($data);

    }
    
        /**
     * deleteRepeateColumns
     *
     * @param  mixed $request
     * @return void
     */
    private function deleteRepeateColumns(array $request)
    {

        $newRequest = [];
        $fullRequest = [];

        foreach($request['name-column'] ?? [] as $k => $name)
        {
            $newRequest[$name] = $k;
        }

        foreach($newRequest as $k)
        {
            $fullRequest['name-column'][] = $request['name-column'][$k];
            $fullRequest['type'][] = $request['type'][$k];
            $fullRequest['length'][] = $request['length'][$k];
            $fullRequest['default'][] = $request['default'][$k];
            $fullRequest['other-default'][] = $request['other-default'][$k];
            $fullRequest['charset'][] = $request['charset'][$k];
        }

        return $fullRequest;

    }

    /**
     * deleteEmptyColumn
     *
     * @return array
     */
    private function deleteEmptyColumns():array
    {

        $request = $this->request->post();
        $newRequest = [
            'name-column'   => [],
            'type'          => [],
            'length'        => [],
            'default'       => [],
            'other-default' => [],
            'charset'       => []
        ];

        if(is_array($request['name-column']) && (count($request['name-column']) > 0)) {
            foreach($request['name-column'] as $key => $name)
            {
                if(empty($name)) {
                    unset($request['name-column'][$key]);
                    unset($request['type'][$key]);
                    unset($request['length'][$key]);
                    unset($request['default'][$key]);
                    unset($request['other-default'][$key]);
                    unset($request['charset'][$key]);
                }
            }
        }

        return $request;

    }
    
    /**
     * checkNumberOfFieldColumns
     *
     * @return void
     */
    private function checkNumberOfFieldColumns()
    {

        $request = $this->deleteEmptyColumns();
        $request = $this->deleteRepeateColumns($request);

        if(count($request['name-column'] ?? []) < 1) {
            echo $this->getErrorToJson('error', 'column_is_empty');

            return false;
        }

        return true;

    }
    
    /**
     * validationCreateTable
     *
     * @return void
     */
    private function validationCreateTable(bool $checkRegistration = true)
    {

        $request = $this->deleteEmptyColumns();
        $request = $this->deleteRepeateColumns($request);

        $types = [
            'int', 'string', 'float', 'date'
        ];
        $defaults = [
            'null', 'date', 'datetime', 'timestamp', 'autoid'
        ];

        $registaration_name = ($checkRegistration === true) ? [
            'life', 'life'
        ] : [];

        /**
         * Функция валидации именни колонки
         */
        $validateNameColumn = function(array $request) use ($registaration_name) {
            $regexNameColumn = '/^[a-z0-9\_]{2,}$/i';
            $error = null;
            $statusValidate = false;
            
            foreach($request['name-column'] as $name)
            {
                $validate = Validator::field('name', $name)
                ->with('name', function($validator) use ($regexNameColumn, $registaration_name, $name) {
                    $validator->validation('regular:'.$regexNameColumn)
                        ->setMessage($this->getErrorToJson('error', 'invalid_name_column'))
                    ->validation('not_only:('.implode(',', $registaration_name).')')
                    ->setMessage(sprintf($this->getErrorToJson('error', 'column_name_register'), $name));
                })
                ->make();

                $statusValidate = $validate->validated;
                $error = $validate->getError();
            }

            return [
                'status' => $statusValidate,
                'error'  => $error
            ];
        };

        /**
         * Конструктор функции валидации types,defults...
         */
        $validateTypeAndDefault = function(array $request, array $data, string $what, string $errorKey) {
            $error = null;
            $statusValidate = false;

            if($request[$what] > 0) {
                foreach($request[$what] as $req)
                {
                    if(!in_array($req, $data)) {
                        $statusValidate = false;
                        $error = $this->getErrorToJson('error', $errorKey);
                    }
                    else $statusValidate = true;
                }
            }
            else $error = $this->getErrorToJson('error', $errorKey);

            return [
                'status' => $statusValidate,
                'error'  => $error
            ];  
        };

        /**
         * Функция валидации типа
         */
        $validateType = function(array $request, array $types) use ($validateTypeAndDefault) {
            return $validateTypeAndDefault($request, $types, 'type', 'invalid_type');
        };

        /**
         * Функция валидации длины
         */
        $validateLength = function(array $request) {
            $error = null;
            $statusValidate = true;

            foreach($request['length'] as $length)
            {
                
                if(!empty($length)) {
                    $validate = Validator::field('length', (int) $length)
                        ->with('length', function($validator) {
                            $validator->validation('integer')
                                ->setMessage($this->getErrorToJson('error', 'invalid_length'));
                        })
                        ->make();

                    $statusValidate = $validate->validated;
                    $error = $validate->getError();
                }
                
                $statusValidate = true;

            }

            return [
                'status' => $statusValidate,
                'error'  => $error
            ];
        };

        /**
         * Функция валидации значения по умолчанию
         */
        $validateDefault = function(array $request, array $defults) use ($validateTypeAndDefault) {
            return $validateTypeAndDefault($request, $defults, 'default', 'invalid_defult');
        };

        /**
         * Функция валидации кодировки колонки
         */
        $validateCharset = function(array $request) use ($validateTypeAndDefault) {
            return $validateTypeAndDefault($request, mb_list_encodings(), 'charset', 'invalid_charset');
        };

        /**
         * Основаная функция валидации полей
         */
        $basic = function(array $request, array $types, array $defaults) use ($validateNameColumn, $validateTypeAndDefault, $validateType, $validateLength, $validateDefault) {
            $errors = [];

            $errors[] = $validateNameColumn($request)['error'];
            $errors[] = $validateType($request, $types)['error'];
            $errors[] = $validateLength($request)['error'];
            $errors[] = $validateDefault($request, $defaults)['error'];

            return $errors;
        };

        $errors = [];

        foreach($basic($request, $types, $defaults) as $k => $error)
        {
            if(!empty($error)) {
                $errors[] = $error;
            }
        }

        if(count($errors) > 0) {
            echo array_shift($errors);

            return false;
        }
        
        return true;
    }
    
    /**
     * validateNameTable
     *
     * @return void
     */
    private function validateNameTable()
    {

        $tableName = trim($this->request->post('table-name'));

        $validate = Validator::field('table-name', $tableName)
            ->with('table-name', function($validator) {
                $validator->validation('min:4')
                    ->setMessage($this->getErrorToJson('error', 'min_symbol_table_name'))
                    ->validation('max:20')
                    ->setMessage($this->getErrorToJson('error', 'max_symbol_table_name'))
                    ->validation('regular:'.$this->regexTablename)
                    ->setMessage($this->getErrorToJson('error', 'invalid_table_name'));
            })
            ->make();

        if($validate->validated === false) {
            echo $validate->getError();

            return false;
        }

        return true;

    }
    
    /**
     * createTable
     *
     * @return void
     */
    public function createTable()
    {

        $dbname = $this->request->get('dbname');
        $table = $this->request->post('table-name');
        $data = [
            'structure' => [],
            'data'      => [
                'data'       => [],
                'statistics' => [
                    'last-request'       => '0000-00-00 00:00',
                    'all-request'        => 0,
                    'id-last-add-record' => '-',
                    'date-create'        => Date::format('Y-m-d H:i')
                ]
            ]
        ];
        $request = $this->deleteEmptyColumns();
        $request = $this->deleteRepeateColumns($request);

        if($this->request->post('add-column-life') === 'on') {
            $request['name-column'][] = 'life';
            $request['type'][] = 'int';
            $request['length'][] = null;
            $request['default'][] = null;
            $request['other-default'][] = null;
            $request['charset'][] = 'UTF-8';
        }

        if(is_array($request['name-column']) && (count($request['name-column']) > 0)) {
            foreach($request['name-column'] as $k => $name)
            {
                $data['structure']['column-'.$k] = [
                    'name-column'   => $name,
                    'type'          => $request['type'][$k],
                    'length'        => empty($request['length'][$k]) ? null : (int) $request['length'][$k],
                    'default'       => $request['default'][$k],
                    'other-default' => $request['other-default'][$k],
                    'charset'       => $request['charset'][$k]
                ];
            }
        }

        if($this->validateNameTable() === true) {
            if($this->existsTable($dbname, $table) === true) {
                echo sprintf($this->getErrorToJson('error', 'table_exists'), $table, $dbname);
            }
            else {
                if($this->checkNumberOfFieldColumns() === true) {
                    if($this->validationCreateTable() === true) {
                        $this->create->createTable($this->getFullServer('server-dir'), $this->getUsername(), $dbname, $table, $data);
                        echo $this->getErrorToJson('success', 'success_create_table', ['redirect' => route('FastDB.open-db').'?dbname='.$dbname]);
                    }
                    else {
                        return false;
                    }
                }
            }
        }

    }
    
    /**
     * delete
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function delete(string $dbname, string $table)
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), 'Databases/'.$this->getUsername().'/database='.$dbname.'/Tables/table='.$table);

        Store::completeRemove($path);
        Flash::name('flash-error')->add('success', sprintf($this->getError('successfull_delete_table'), $table));

        Redirector::back()->redirect();

    }
    
    /**
     * executeMoveTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    private function executeMoveTable(string $dbname, string $table, string $dbnameNew, string $tableNew)
    {
        if($this->common->existsTable($dbnameNew, $tableNew) === false) {
            $path = $this->getPathServer($this->getFullServer('server-dir'), 'Databases/'.$this->getUsername()).'/';
            $pathWith = $path.'database='.$dbname.'/Tables/table='.$table;
            $pathTo = $path.'database='.$dbnameNew.'/Tables/table='.$tableNew;

            Store::move($pathWith, $pathTo);
            Flash::name('flash-error')->add('success', $this->getError('settings_table_success_save'));
        } else {

            Flash::name('flash-error')->add('success', sprintf($this->getError('move_table_redirect'), $tableNew));
        }
    }
        
    /**
     * vaidateTableNameSettings
     *
     * @return void
     */
    private function vaidateTableNameSettings()
    {

        $tableName = trim($this->request->post('table-name'));

        $validate = Validator::field('table-name', $tableName)
            ->with('table-name', function($validator) {
                $validator->validation('min:4')
                    ->setMessage($this->getError('min_symbol_table_name'))
                    ->validation('max:20')
                    ->setMessage($this->getError('max_symbol_table_name'))
                    ->validation('regular:'.$this->regexTablename)
                    ->setMessage($this->getError('invalid_table_name'));
            })
            ->make();

        if($validate->validated === false) {
            Flash::name('flash-error')->add('error', $validate->getError());

            return false;
        }

        return true;

    }

    /**
     * settingsTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @param  mixed $newDbname
     * @param  mixed $newTable
     * @return void
     */
    public function settingsTable(string $dbname, string $table, string $newDbname, string $newTable)
    {

        if($this->vaidateTableNameSettings() === true) {
            if($dbname !== $newDbname || $table !== $newTable) {
                if($this->common->existsDb($newDbname) === true) {
                    $this->executeMoveTable($dbname, $table, $newDbname, $newTable);
                }
            }
            else {
                $this->executeMoveTable($dbname, $table, $newDbname, $newTable);
            }
        } else {
            Redirector::back()->redirect();

            return true;
        }

        Redirector::his(route('FastDB.settings-table').'?dbname='.$newDbname.'&table='.$newTable)->redirect();

    }
        
    /**
     * getInfoTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @param  mixed $file
     * @return void
     */
    private function getInfoTable(string $dbname, string $table, string $file)
    {

        $path = $this->getPathOfTable($dbname, $table, $file);

        return Response::jsonToArray(Store::getApi($path));

    }

    /**
     * getStructure
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function getStructure(string $dbname, string $table)
    {

        return $this->getInfoTable($dbname, $table, 'structure.fd');

    }
    
    /**
     * getData
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function getData(string $dbname, string $table)
    {

        return $this->getInfoTable($dbname, $table, 'data.fd');

    }
        
    /**
     * getPathOfTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @param  mixed $file
     * @return void
     */
    private function getPathOfTable(string $dbname, string $table, string $file)
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), sprintf('Databases/%s/database=%s/Tables/table=%s', $this->getUsername(), $dbname, $table));

        return $path.'/'.$file;

    }

    /**
     * cleansTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function cleansTable(string $dbname, string $table)
    {

        Store::editJsonFile($this->getPathOfTable($dbname, $table, 'data.fd'))->editJsonData(function($data) {

            $data['data'] = [];

            return $data;
        });

        Flash::name('flash-error')->add('success', $this->getError('successfull_cleans_table'));
        Redirector::back()->redirect();

    }
    
    /**
     * addDataHandler
     *
     * @param  mixed $structure
     * @param  mixed $request
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    private function addDataHandler(array $structure, array $request, string $dbname, string $table)
    {

        Store::editJsonFile($this->getPathOfTable($dbname, $table, 'data.fd'))
            ->editJsonData(function($data) use ($request, $structure) {
                $newData = [];
                foreach($data['data'] as $datas)
                {
                    foreach($datas as $key => $value)
                    {
                        if(!array_key_exists($key, $request)) {
                            $request[$key] = $key === 'life' ? -1 : '';
                        }
                    }
                }
                foreach($request as $k => $v)
                {
                    $methodDefault = one_up_line($structure[$k]['default']);
                    $methodType = one_up_line($structure[$k]['type']);
                    
                    if($k === 'life') {
                        $v = $v < 0 ? -1 : Date::unix() + $v;
                    }

                    if(empty($v)) {
                        if(empty($structure[$k]['other-default'])) {
                            $newData[array_key_last($data['data']) + 1][$k] = $this->defaults->$methodDefault();
                        } else {
                            $newData[array_key_last($data['data']) + 1][$k] = $structure[$k]['other-default'];
                        }
                    } else {
                        $newData[array_key_last($data['data']) + 1][$k] = $this->types->$methodType(mb_convert_encoding($v, $structure[$k]['charset'], mb_detect_encoding($v)));
                    }
                }

                $data['data'] += $newData;
                $data['statistics']['all-request'] += 1;
                $data['statistics']['last-request'] = Date::format('Y-m-d H:i');
                $data['statistics']['id-last-add-record'] = count($data['data']);

                return $data;
            });

    }
        
    /**
     * editRequestFieldsAddAndEditData
     *
     * @return void
     */
    private function editRequestFieldsAddAndEditData(string $dbname, string $table)
    {

        $request = $this->request->post();
        $structure = $this->getStructure($dbname, $table);
        $newStructure = [];

        foreach($structure as $key => $columns)
        {
            $newStructure[$columns['name-column']] = $structure[$key];
        }

        foreach($request as $key => $value)
        {
            if(!array_key_exists($key, $newStructure)) {
                unset($request[$key]);
            }
        }

        return [
            'newStructure' => $newStructure,
            'request'      => $request,
        ];

    }

    /**
     * embedData
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function embedData(string $dbname, string $table)
    {

        $fullRequest = $this->editRequestFieldsAddAndEditData($dbname, $table);

        $this->addDataHandler($fullRequest['newStructure'], $fullRequest['request'], $dbname, $table);
        Redirector::route('FastDB.watch-table', ['db' => $dbname, 'table' => $table])->redirect();

    }
    
    /**
     * deleteTableData
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function deleteTableData(string $dbname, string $table)
    {

        $request = $this->request->post('unique-id-record');
        $storageModel = $this->model->load('Storage');
        $usersModel = $this->model->load('Users');

        if(Common::getMethod() === 'GET') {
            $request[] = $this->request->get('id');
        }
        

        Store::editJsonFile($this->getPathOfTable($dbname, $table, 'data.fd'))
            ->editJsonData(function($data) use ($request, $storageModel, $usersModel, $dbname, $table) {
                foreach($request as $id)
                {
                    if(array_key_exists($id, $data['data'])) {
                        $storageModel->save($usersModel, $dbname, $table, $this->getData($dbname, $table)['data'][$id]);
                        
                        unset($data['data'][$id]);
                    }
                }

                return $data;
            });

        Redirector::back()->redirect();

    }
    
    /**
     * editData
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @param  mixed $id
     * @return void
     */
    public function editData(string $dbname, string $table, int $id)
    {

        $fullRequest = $this->editRequestFieldsAddAndEditData($dbname, $table);
        $request = $fullRequest['request'];
        $structure = $fullRequest['newStructure'];

        Store::editJsonFile($this->getPathOfTable($dbname, $table, 'data.fd'))
            ->editJsonData(function($data) use ($request, $id, $dbname, $table, $structure) {
                if(isset($data['data'][$id])) {
                    foreach($request as $k => $v)
                    {
                        $methodDefault = one_up_line($structure[$k]['default']);
                        $methodType = one_up_line($structure[$k]['type']);
                        
                        if($k === 'life') {
                            $v = $v < 0 ? -1 : Date::unix() + $v;
                        }

                        if(empty($v)) {
                            if(empty($structure[$k]['other-default'])) {
                                $data['data'][$id][$k] = $this->defaults->$methodDefault();
                            } else {
                                $data['data'][$id][$k] = $structure[$k]['other-default'];
                            }
                        } else {
                            $data['data'][$id][$k] = $this->types->$methodType(mb_convert_encoding($v, $structure[$k]['charset'], mb_detect_encoding($v)));
                        }
                    }

                    if($this->request->get('ajax') == 1) {
                        echo $this->getErrorToJson('success', 'success_edit_data_table');
                    } else {
                        Redirector::route('FastDB.watch-table', ['db' => $dbname, 'table' => $table])->redirect();
                    }
                }

                return $data;
            });

    }
    
    /**
     * editStructure
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function editStructure(string $dbname, string $table)
    {

        $request = $this->deleteEmptyColumns();
        $request = $this->deleteRepeateColumns($request);
        $dataReq = [];

        if(is_array($request['name-column']) && (count($request['name-column']) > 0)) {
            foreach($request['name-column'] as $k => $name)
            {
                $dataReq['column-'.$k] = [
                    'name-column'   => $name,
                    'type'          => $request['type'][$k],
                    'length'        => empty($request['length'][$k]) ? null : (int) $request['length'][$k],
                    'default'       => $request['default'][$k],
                    'other-default' => $request['other-default'][$k],
                    'charset'       => $request['charset'][$k]
                ];
            }
        }

        if($this->checkNumberOfFieldColumns() === true) {
            if($this->validationCreateTable(false) === true) {
                Store::editJsonFile($this->getPathOfTable($dbname, $table, 'structure.fd'))
                    ->editJsonData(function($data) use ($dataReq) {
                        $data = $dataReq;
                        return $data;
                    });
                Store::editJsonFile($this->getPathOfTable($dbname, $table, 'data.fd'))
                    ->editJsonData(function($data) use ($request) {
                        foreach($this->request->post('old-name-column') as $k => $oldColumn)
                        {
                            foreach($data['data'] as $key => $record)
                            {
                                $data['data'][$key] = renameArrayKey($data['data'][$key], $oldColumn, $request['name-column'][$k]);

                                foreach($record as $kNameColumn => $v)
                                {
                                    if(!in_array($kNameColumn, $this->request->post('old-name-column')) && !in_array($kNameColumn, $request['name-column'])) {
                                        unset($data['data'][$key][$kNameColumn]);
                                    }
                                }
                            }
                        }

                        foreach($request['name-column'] as $k => $v)
                        {
                            foreach($data['data'] as $key => $record)
                            {
                                if(array_key_exists($v, $record) === false) {
                                    $data['data'][$key][$v] = null;
                                }
                            }
                        }

                        return $data;
                    });

                    echo $this->getErrorToJson('success', 'success_edit_structure', ['redirect' => route('FastDB.watch-table', ['db' => $dbname, 'table' => $table])]);
            }
            else {
                return false;
            }
        }

    }

    /**
     * __call
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        
        return call_user_func_array([$this->conf, $name], $arguments);

    }
   

}