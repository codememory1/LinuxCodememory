<?php

namespace FastDB\ComponentsClasses\Commands\Handler\Exceptions;

use \ErrorException;

/**
 * InvalidCommandException
 */
class InvalidCommandException extends ErrorException
{

    public function __construct(array $data)
    {

        parent::__construct(sprintf('An error occurred with the database: <b>FastDB</b>. Command: <b>«%s»</b> Not Found Or Invalid Arguments, Check Commands Documentation. Code Executed in file: <b>«%s»</b> in line: <b>%s</b>', $data[0]['args'][0], $data[0]['file'], $data[0]['line']));

    }

}