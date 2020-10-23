<?php

namespace FastDB\ComponentsClasses\Commands\Handler\Exceptions;

use \ErrorException;

/**
 * ErrorExecuteCommandException
 */
class ErrorExecuteCommandException extends ErrorException
{

    public function __construct($data)
    {
        parent::__construct(sprintf('An error occurred with the database: <b>FastDB</b>. Command: <b>«%s»</b> could not be executed due to unknown errors. This command may have been removed earlier. Code Executed in file: «%s» in line: <b>%s</b>', $data[0]['args'][0], $data[0]['file'], $data[0]['line']));
    }

}