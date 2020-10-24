<?php

namespace System\Codememory\CodememoryConfigurationLanguage;

use System\Codememory\CodememoryConfigurationLanguage\CompilerFunctions;
use System\Codememory\CodememoryConfigurationLanguage\HandleFunctionsCompiler;
use Url;
use Store;
use File;

class ReinforcerCodememory
{
	
	const PATH_COMPILATION = 'system/Codememory/CodememoryConfigurationLanguage/CompilationFiles/';
	
	private static $redefinition = [
		'Yes' => 'true',
		'No'  => 'false'
	];

	private static $files = [];
		
	/**
	 * allRein
	 *
	 * @return void
	 */
	public static function allRein()
	{
		
		File::import('config/Codememory/codememory-lang.php');
		
		return self::$files;
		
	}
		
	/**
	 * readRein
	 *
	 * @param  mixed $file
	 * @return void
	 */
	public static function readRein($file)
	{
		
		return Store::getApi($file);
		
	}
		
	/**
	 * register
	 *
	 * @param  mixed $file
	 * @return void
	 */
	public static function register($file)
	{
		
		self::$files[] = $file;
		
		return new ReinforcerCodememory();
		
	}
		
	/**
	 * handle
	 *
	 * @return void
	 */
	private static function handle()
	{
		
		$func = new CompilerFunctions();
		$handle = new HandleFunctionsCompiler();

		foreach(self::allRein() as $file)
		{
			
			list($f, $expan) = explode('.', $file);
			
			$check = self::readRein($file);

			foreach($func->getCompiler() as $k => $regexp)
			{
				
				$search = preg_match_all($regexp, $check, $match);
				
				if($search > 0)
				{
					$nameMethod = 'func'.one_up_line(down_line($k));
					$check = $handle->$nameMethod($match, $check);
				}
			}

			$check = Store::replace(self::$redefinition, $check);

			Store::overwrite(self::PATH_COMPILATION.md5($f), '<?php'.PHP_EOL.PHP_EOL.$check.PHP_EOL.'/* Codememory Framework Compiler */', '.php');
			
		}
		
	}
		
	/**
	 * open
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public static function open($path)
	{
		
		require getcwd().'/'. self::PATH_COMPILATION.md5($path).'.php';
		
		return [
			'vars' => $_VARS
		];
		
	}
		
	/**
	 * compline
	 *
	 * @return void
	 */
	public static function compline()
	{
		
		self::handle();
		
	}
	
}
