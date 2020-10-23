<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationTraits;

trait ChangeTableSettingsTrait
{
    
    /**
     * newTableName
     *
     * @var string
     */
    private $newTableName;

    /**
     * dbnameWhenMoving
     *
     * @var string
     */
    private $dbnameWhenMoving;
    
    /**
     * renameTable
     *
     * @param  mixed $table
     * @return void
     */
    public function renameTable(string $table)
    {

        $this->newTableName = $table;

        return $this;

    }

    /**
     * moveToDatabase
     *
     * @param  mixed $dbname
     * @return void
     */
    public function moveToDatabase(string $dbname)
    {
        
        $this->dbnameWhenMoving = $dbname;

        return $this;

    }

}