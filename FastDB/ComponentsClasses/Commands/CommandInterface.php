<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;

interface CommandInterface 
{

    public function configurate();

    public function execute(InputCommandInterface $input);

}