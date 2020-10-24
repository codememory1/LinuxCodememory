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
class ShowDataCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('SHOW %fields OF TABLE %table %flags')
            ->setRequired('fields')
            ->setRequired('table')
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

        try {
            $fields = up_line($input->input()->fields[0]) === 'ALL' ? [] : explode(',', $input->input()->fields[0]);
            $data = $this->getQuery()->table($input->input()->table[0])->select($fields);

            $flagsComponent = new FlagsComponentCommand($data);
            $result = $flagsComponent->execute($input->input()->flags[0])->fetch();

            return $result;
        } catch(Exception $e) {
            return false;
        }

    }

}