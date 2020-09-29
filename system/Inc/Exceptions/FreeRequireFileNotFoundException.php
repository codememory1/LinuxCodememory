<?php

namespace System\Inc\Exceptions;

use \ErrorException;

class FreeRequireFileNotFoundException extends ErrorException
{
	
	private $file_name;
	
	public function __construct($file_name)
	{
		
		parent::__construct("File: <b>${file_name}</b> dont exists.");
		
		$this->file_name = $file_name;
		
	}
	
	public function getFileName()
	{
		
		return $this->file_name;
		
	}
	
}