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
class DeleteDataCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('DELETE RECORD OF TABLE %table %flags')
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
            $data = $this->getQuery()->table($input->input()->table[0])->delete();

            $flagsComponent = new FlagsComponentCommand($data);
            $result = $flagsComponent->execute($input->input()->flags[0])->exec();

            return $result;
        } catch(Exception $e) {
            return false;
        }

    }

}