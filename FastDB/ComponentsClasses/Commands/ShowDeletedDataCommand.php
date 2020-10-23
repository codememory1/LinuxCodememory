<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\FlagsComponentCommand;
use FastDB;

/**
 * ShowDeletedDataCommand
 */
class ShowDeletedDataCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('SHOW DELETED RECORDS');

    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @return void
     */
    public function execute(InputCommandInterface $input)
    {
        try {
            return FastDB::showStorerDeletedData()->fetch();
        } catch(Exception $e) {
            return false;
        }

    }

}