<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\FlagsComponentCommand;
use FastDB;

/**
 * ShowDataCommand
 */
class JoinTablesCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('JOIN TABLE %table %flags TO TABLE %totable %toflags')
            ->setRequired('table')
            ->setRequired('totable')
            ->setOptions('flags', 'FLAGS', false)
            ->setOptions('toflags', 'FLAGS', false);

    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @return void
     */
    public function execute(InputCommandInterface $input)
    {

        

    }

}