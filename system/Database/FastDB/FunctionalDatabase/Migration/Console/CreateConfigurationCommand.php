<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use System\Database\Fastdb\FunctionalDatabase\Migration\Configuration;

/**
 * CreateConfigurationCommand
 */
class CreateConfigurationCommand extends Command
{
	
    protected static $defaultName = 'FastDB:create-configuration';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {
		
        $this->setDescription('Создает файл конфигурации');
		
    }
    
    /**
     * execute
     *
     * @param  mixed $input
     * @param  mixed $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

		$conf = new Configuration();
		
		$exampleConfig = file_get_contents('system/Database/FastDB/FunctionalDatabase/Migration/ConfigurationExample.sudo');
		
		$create = file_put_contents(Configuration::NAME_FILE_CONFIG, $exampleConfig);
		
		($create) ? 
			$output->writeln('<info>Файл конфигурации создан.</info>') :
		$output->writeln('<error>Ошибка: файл конфигурации не создан.</error>');
			
		return 1;
		
    }
	
}