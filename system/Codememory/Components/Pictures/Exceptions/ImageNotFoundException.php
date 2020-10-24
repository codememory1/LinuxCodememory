<?php

namespace System\Codememory\Components\Pictures\Exceptions;

use \ErrorException;

/**
 * ImageNotFoundException
 */
class ImageNotFoundException extends ErrorException
{

    
    /**
     * __construct
     *
     * @param  mixed $path
     * @return void
     */
    public function __construct($path)
    {

        parent::__construct(sprintf('Image for address: [%s] not found.', $path));

    }

}