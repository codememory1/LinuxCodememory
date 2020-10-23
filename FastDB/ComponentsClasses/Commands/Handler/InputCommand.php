<?php

namespace FastDB\ComponentsClasses\Commands\Handler;

use FastDB\ComponentsClasses\Commands\Handler\Interfaces\InputCommandInterface;

/**
 * InputCommand
 */
class InputCommand implements InputCommandInterface
{

    private $match;

    public function __construct($match)
    {

        $this->match = $match;

    }
    
    /**
     * input
     *
     * @return void
     */
    public function input()
    {

        return (object) $this->match;

    }

}