<?php

namespace FastDB\ComponentsClasses\Commands\Exceptions;

use \ErrorException;

/**
 * InvalidCommandException
 */
class FlagNotFoundException extends ErrorException
{

    public function __construct(array $data, string $flag)
    {

        parent::__construct(sprintf('An error occurred with the database: <b>FastDB</b>. Flag: <b>«%s»</b> Not Found. Code Executed in file: <b>«%s»</b> in line: <b>%s</b>', $flag, $data[0]['file'], $data[0]['line']));

    }

}