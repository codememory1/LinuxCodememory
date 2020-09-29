<?php

namespace System\ENV\Console;

use System\Support\Random;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class UpdateAppKeyCommand extends Command
{
	
    protected static $defaultName = 'app:update_key';

    protected function configure()
    {
		
        $this->setDescription('Обновляет секретный ключ');
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
		$env = file_get_contents('.env');
		$env = explode(PHP_EOL, $env);
		
		$e = null;
		$keyRand = null;
		
		foreach($env as $envs)
		{
			list($key, $value) = explode(' = ', $envs);
			
			if($key == 'APP_KEY')
			{
				$value = Random::randAny(36);
				
				$keyRand = $value;
			}
			
			$e .= (empty($key) || empty($value)) ? 
				PHP_EOL : 
			$key.' = '.$value.PHP_EOL;
		} 
		
		$e = preg_replace ('/^\s*|\s*$/', '', $e);
		
		$update = file_put_contents('.env', $e);
		
		($update) ? 
			$output->writeln(sprintf('<info>Ключ обновлен на "%s"</info>', $keyRand)) :
		$output->writeln('<error>Ошибка: ключ не обновлен.</error>');
		
			
		return 1;
		
    }
	
}