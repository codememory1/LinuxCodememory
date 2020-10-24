<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\FlagsComponentCommand;
use FastDB;

/**
 * UpdateDataCommand
 */
class UpdateDataCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('UPDATE RECORD IN TABLE %table %fields %values %flags')
            ->setRequired('table')
            ->setValues('fields', 'COLUMNS', true)
            ->setValues('values', 'VALUES', true)
            ->setOptions('flags', 'FLAGS', false);

    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @return void
     */
    public function execute(InputCommandInterface $input)
    {

        $fields = array_map(function($value) {
            return trim($value);
        }, explode(',', $input->input()->fields[0]));
        $values = array_map(function($value) {
            return trim($value);
        }, explode(',', $input->input()->values[0]));

        try {
            $flagsComponent = new FlagsComponentCommand(
                    $this->getQuery()
                        ->table($input->input()->table[0])
                        ->columns($fields)
                        ->values($values)
                        ->update()
            );
            $result = $flagsComponent->execute($input->input()->flags[0])->exec();

            return true;
        } catch(Exception $e) {
            return false;
        }

    }

}