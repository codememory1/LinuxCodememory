<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Codememory\Components\UploadFiles\Upload;

/**
 * Class ServiceRequest
 * @package System\Service
 */
class ServiceUpload extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'upload';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Upload();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}