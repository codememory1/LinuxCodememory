<?php

namespace System\Codememory\CodememoryConfigurationLanguage;

class CompilerFunctions
{
	
	const COMPILER = [
		
		'require'  	  => '/(import\-file)\s+([^\s+\!!]+)/',
		'use'	   	  => '/(import)\s+([^\s+\!!]+)/',
		'var'	   	  => '/var\s+([^\-\.\s+\=\,]+)(?:\s)?\=(?:\s)?((?:(\[.*\])\s+)?([^\!!]+))/',
		'watchvar' 	  => '/wVar\{([^\-\.\s+\=]+)\}/',
		'exportvars'  => '/(export\-vars)\s+([^\s+\!!]+)/',
		'end'	   	  => '/\!\!/',
		'coments'	  => '/\#(.*)\#/'
		
	];
	
	public function getCompiler()
	{
		
		return self::COMPILER;
		
	}
	
}