<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\Console;

use System\Codememory\Console\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use System\Database\Fastdb\FunctionalDatabase\Migration\Configuration;

/**
 * CreateMigrationCommand
 */
class CreateMigrationCommand extends Command
{
	
    protected static $defaultName = 'FastDB:migration:create';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {
		
        $this->setDescription('Создание миграции FastDB')
			->addArgument('name', InputArgument::REQUIRED, 'Имя миграции')
			->setHelp('Создает Миграцию указав 1 аргумент "имя миграции"');
		
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

		$nameMigration = 'FastDB_Migration_'.$input->getArgument('name');
		$conf = new Configuration();
		
		$open = $conf->open();
		
		$getExampleController = file_get_contents('system/Database/FastDB/FunctionalDatabase/Migration/MigrationExample.sudo');
		$replaceExample = str_replace('%MIGRATION_CLASS', $nameMigration, $getExampleController);
		
		$create = file_put_contents($open->getData('pathMigration').'/'.$nameMigration.'.php', $replaceExample);
		
		($create) ? 
			$output->writeln(sprintf('<info>Миграция "%s" создан.</info>', $nameMigration)) :
		$output->writeln('<error>Ошибка: миграция не создан.</error>');
			
		return 1;

    }
	
}