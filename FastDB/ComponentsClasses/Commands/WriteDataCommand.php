<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB;

/**
 * WriteDataCommand
 */
class WriteDataCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('EMBED RECORD IN TABLE %table %fields %values')
            ->setRequired('table')
            ->setValues('fields', 'COLUMNS', true)
            ->setValues('values', 'VALUES', true);

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
        $values = $input->input()->values[0];

        preg_match_all('/\`([^\`]*)\`/', $values, $matchesValues);
        $values = array_map(function($value) {
            return trim($value);
        }, $matchesValues[1]);

        try {
            $this->getQuery()
                ->table($input->input()->table[0])
                ->columns($fields)
                ->values($values)
                ->embed()
                ->exec();

            return true;
        } catch(Exception $e) {
            return false;
        }

    }

}