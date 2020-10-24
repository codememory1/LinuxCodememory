<?php

namespace App\Models;

use System\Codememory\RegisterService;
use System\Authentication\Authorization;
use App\Models\Repositories\ConfigurationRepository;
use Flash;
use Redirector;
use Response;
use Store;

/**
 * CommonModel
 * @package System\Codememory
 */
class CommonModel extends RegisterService
{
        
    /**
     * conf
     *
     * @var mixed
     */
    private $conf;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();

        $this->conf = new ConfigurationRepository();

    }
    
    /**
     * invalidToken
     *
     * @return void
     */
    public function invalidToken()
    {

        $token = $this->request->withHeaderToken(false)
            ->withToken();

        if($token->statusToken()['status'] === false)
        {
            Flash::name('flash-error')->add('error', 'Некорректный токен запроса');

            Redirector::back()->redirect();

            return false;
        }

        return true;

    }
    
    /**
     * uncompressFormat
     *
     * @param  mixed $file
     * @return void
     */
    public function uncompressFormat(string $file)
    {

        return Store::uncompress(Response::jsonToArray(Store::getApi($file)));

    }
    
    /**
     * compressFormat
     *
     * @return void
     */
    public function compressFormat(string $file)
    {

        return Store::compress(Response::jsonToArray(Store::getApi($file)));

    }

    /**
     * getCountMemory
     *
     * @return int
     */
    public function getCountMemory()
    {

        $userdata = $this->conf->getUserData($this->conf->getFullServer('server-dir'), $this->conf->getUsername());
        $all = Store::completeSizeArray([
            $this->conf->getPathDb($this->conf->getFullServer()['server-dir'], $this->conf->getUsername()),
            $this->conf->getPathServer($this->conf->getFullServer()['server-dir'], 'Users'),
            $this->conf->getPathServer($this->conf->getFullServer()['server-dir'], 'Representation/'.$this->conf->getUsername())
        ]);

        return [
            'b'   => $all,
            'kb'  => round($all / 1000),
            'mb'  => round($all / 1e+6),
            'all' => [
                'b'  => round($userdata['memory']['of'] * 1e+6),
                'kb' => round($userdata['memory']['of'] * 1000),
                'mb' => $userdata['memory']['of']
            ]
        ];

    }
    
    /**
     * memoryCheck
     *
     * @return void
     */
    public function memoryCheck()
    {

        $userdata = $this->conf->getUserData($this->conf->getFullServer('server-dir'), $this->conf->getUsername());

        if($this->getCountMemory()['mb'] >= $userdata['memory']['of']) {
            Flash::name('flash-error')->add('error', 'Не удалось выполнить запрос. Недостаточно памяти.');
            Redirector::back()->redirect();

            return false;
        }

        return true;

    }
    
    /**
     * existsDb
     *
     * @param  mixed $dbname
     * @return void
     */
    public function existsDb($dbname)
    {

        $server = $this->conf->getFullServer('server-dir');
        $username = $this->conf->getUsername();

        $pathInDb = $this->conf->getPathServer($server, 'Databases/'.$username.'/');

        return Store::isDir($pathInDb.'database='.$dbname);

    }
    
    /**
     * existsTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function existsTable($dbname, $table)
    {

        $server = $this->conf->getFullServer('server-dir');
        $username = $this->conf->getUsername();

        $pathInDb = $this->conf->getPathServer($server, 'Databases/'.$username.'/database='.$dbname);

        return Store::exists($pathInDb.'/Tables/table='.$table);

    }
    
    /**
     * getAccess
     *
     * @param  mixed $accessKey
     * @return void
     */
    public function getAccess(string $accessKey)
    {

        return $this->conf->getUserData($this->conf->getFullServer('server-dir'), $this->conf->getUsername())['access-rights'][$accessKey];

    }
    
    /**
     * checkAccess
     *
     * @param  mixed $accessKey
     * @return void
     */
    public function checkAccess(string $accessKey)
    {
    
        if($this->getAccess($accessKey) === false || $this->getAccess($accessKey) === null)
        {
            Response::setResponseCode(403)->getResponseCode();
            $this->view->big(403);

            exit();
        }

    }

}