<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB;

/**
 * ShowDatabasesCommand
 */
class ShowDatabasesCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('SHOW DATABASES %as')
            ->setValues('as', 'WITH', false);

    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @return void
     */
    public function execute(InputCommandInterface $input)
    {

        return FastDB::showDatabasesWithTables($input->input()->as[0] ?? 'DB')->execute();

    }

}