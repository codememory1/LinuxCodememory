<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\FlagsComponentCommand;
use System\Database\FastDB\WorkInterface\Components;

/**
 * ShowDataCommand
 */
class CreateTable extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('CREATE TABLE %table %structure')
            ->setRequired('table')
            ->setValues('structure', 'STRUCTURE', true);

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
            $table = $input->fields->table[0];

            return $result;
        } catch(Exception $e) {
            return false;
        }

    }

}