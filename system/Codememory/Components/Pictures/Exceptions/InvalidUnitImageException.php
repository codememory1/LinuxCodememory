<?php

namespace System\Codememory\Components\Pictures\Exceptions;

use \ErrorException;

/**
 * InvalidUnitImageException
 */
class InvalidUnitImageException extends ErrorException
{

    
    /**
     * __construct
     *
     * @param  mixed $list
     * @return void
     */
    public function __construct($list)
    {

        parent::__construct(sprintf('Unit is invalid. List of all units: [%s]', $list));

    }

}