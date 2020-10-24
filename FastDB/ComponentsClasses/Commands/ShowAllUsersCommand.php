<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB;

/**
 * ShowAllUsersCommand
 */
class ShowAllUsersCommand extends Commands implements CommandInterface
{

    public function configurate()
    {

        $this->setCommand('SHOW USERS');

    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @return void
     */
    public function execute(InputCommandInterface $input)
    {

        return FastDB::showAllUsers()->execute();

    }

}