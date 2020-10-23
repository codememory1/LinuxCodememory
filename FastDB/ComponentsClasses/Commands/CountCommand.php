<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;
use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\FlagsComponentCommand;
use FastDB;

class CountCommand extends Commands implements CommandInterface
{
    
    /**
     * configurate
     *
     * @return void
     */
    public function configurate()
    {

        $this->setCommand('COUNT RECORDS IN TABLE %table %flags')
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

        $data = FastDB::table($input->input()->table[0])->count();

        $flagsComponent = new FlagsComponentCommand($data);
        $result = $flagsComponent->execute($input->input()->flags[0])->execute();

        return $result;

    }

}