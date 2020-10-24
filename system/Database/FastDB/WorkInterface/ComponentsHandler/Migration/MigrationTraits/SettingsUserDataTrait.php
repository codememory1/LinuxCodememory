<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationTraits;

trait SettingsUserDataTrait
{
    
    /**
     * userSettings
     *
     * @var array
     */
    private $userSettings = [
        'username'             => null,
        'password'             => null,
        'save-deleted-data'    => null,
        'as-save-deleted-data' => 'local',
        'privilege'            => [],
        'max-memory'           => null,
        'freeze-account'       => 'off'
    ];
    
    /**
     * diskPath
     *
     * @var string
     */
    private $pathDisk;
        
    /**
     * username
     *
     * @param  mixed $username
     * @return void
     */
    public function username(string $username)
    {

        $this->userSettings['username'] = $username;

        return $this;
        
    }

    /**
     * password
     *
     * @param  mixed $password
     * @return void
     */
    public function password(string $password)
    {

        $this->userSettings['password'] = $password;

        return $this;

    }
    
    /**
     * saveDeletedData
     *
     * @param  mixed $save
     * @return void
     */
    public function saveDeletedData(bool $save = false)
    {

        $this->userSettings['save-deleted-data'] = $save === true ? 'on' : 'off';

        return $this;

    }
    
    /**
     * asSaveDeletedData
     *
     * @param  mixed $as
     * @return void
     */
    public function asSaveDeletedData(string $as)
    {

        $this->userSettings['as-save-deleted-data'] = $as;

        return $this;

    }
    
    /**
     * setPrivilege
     *
     * @param  mixed $privilege
     * @param  mixed $status
     * @return void
     */
    public function setPrivilege(string $privilege, bool $status = true)
    {

        $this->userSettings['privilege'][$privilege] = $status === true ? 'on' : 'off';

        return $this;

    }
    
    /**
     * setAmoutMemory
     *
     * @param  mixed $amount
     * @return void
     */
    public function setAmoutMemory(int $amount = 50)
    {

        $this->userSettings['max-memory'] = $amount;

        return $this;

    }
    
    /**
     * freeze
     *
     * @param  mixed $freeze
     * @return void
     */
    public function freeze(bool $freeze = false)
    {

        $this->userSettings['freeze-account'] = $freeze === true ? 'on' : 'off';

        return $this;

    }
    
    /**
     * setPathDisk
     *
     * @param  mixed $disk
     * @param  mixed $folderPath
     * @return void
     */
    public function setPathDisk(string $disk, ?string $folderPath = null)
    {

        $this->userSettings['path-save-local'] = $disk.':/'.trim($folderPath, '/').'/';

        return $this;

    }

}