<?php

namespace System\Codememory\CodememoryConfigurationLanguage;

use Store;

class HandleFunctionsCompiler
{
	
	public function funcRequire(array $data, $code)
	{
		
		$fullCode = $code;
		
		foreach($data[2] as $k => $val)
		{
			
			$newV = Store::replace(['.' => '/'], $val);
			
			$regexp = '/import\-file\s+('.$val.')/';
			
			$pathImport = 'system/Codememory/CodememoryConfigurationLanguage/CompilationFiles/'.md5($newV).'.php';
			
			$fullCode = preg_replace($regexp, "require '$pathImport'", $fullCode);
			
		}
		
		return $fullCode;
		
	}
	
	public function funcUse(array $data, $code)
	{
		
		$fullCode = $code;
		
		foreach($data[2] as $k => $val)
		{
			
			$newV = Store::replace(['.' => '\\'], $val);
			
			$regexp = '/import\s+('.$val.')/';

			$fullCode = preg_replace($regexp, 'use '.$newV, $fullCode);
			
		}
		
		return $fullCode;
		
		
	}
	
	public function funcVar(array $data, $code) 
	{

		unset($data[2]);

		$fullCode = $code;

		foreach($data[1] as $k => $val)
		{
			
			$regexpVar = '/var\s+('.$data[0][$k].')(?:\s)?\=(?:\s)?('.preg_quote($val, '/').')/';
			
			$funcString = preg_match('/\`(.*)\`/', $data[4][$k]) === 1 ? substr($data[4][$k], 1, -1) : '"'.$data[4][$k].'"';
			
			if(isset($data[3]) && count($data[3]) > 0)
			{
				$fullCode = str_replace($data[0][$k], '$'.$data[1][$k].$data[3][$k].' = '.$funcString, $fullCode);
			}
			else {
				$fullCode = str_replace($data[0][$k], '$'.$data[1][$k].' = '.$funcString, $fullCode);
			}
			
		}

		return $fullCode;
		
	}
	
	public function funcEnd(array $data, $code)
	{
		
		return Store::replace(['!!' => ';'], $code);
		
	}
	
	public function funcWatchvar(array $data, $code)
	{
		
		$fullCode = $code;
		
		foreach($data[1] as $k => $val)
		{
			
			$fullCode = preg_replace('/wVar\{('.preg_quote($val, '/').')\}/', '$$1', $fullCode);
			
		}
		
		return $fullCode;
		
	}
	
	public function funcExportvars(array $data, $code)
	{
		
		$vars = explode(',', $data[2][0]);
		
		$fullCode = $code;
		
		$exportVars = null;
		
		foreach($vars as $var)
		{
			
			$exportVars .= '$_VARS["'.$var.'"] = $'.$var.'!!'.PHP_EOL;
			
		}
		
		$fullCode = preg_replace('/export\-vars\s+('.preg_quote($data[2][0]).')/', $exportVars, $fullCode);
		
		return $fullCode.PHP_EOL.'extract($_VARS);';
		
	}
	
	public function funcComents(array $data, $code)
	{
		
		$fullCode = $code;
		
		$fullCode = preg_replace('/\#(.*)\#/', '// $1', $fullCode);
		
		return $fullCode;
		
	}
	
}