<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use System\Database\Fastdb\FunctionalDatabase\Migration\Configuration;

/**
 * RunMigrationCommand
 */
class RunMigrationCommand extends Command
{
	
    protected static $defaultName = 'FastDB:migration:run';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {
		
        $this->setDescription('Запускает миграцию FastDB')
			->addArgument('name', InputArgument::REQUIRED, 'Имя миграции');
		
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
		$open = $conf->open();

		$nameMigration = 'FastDB_Migration_'.$input->getArgument('name');
		
		if(file_exists($open->getData('pathMigration').$nameMigration.'.php'))
		{
			$namespaceMigration = str_replace('/', '\\', $open->getData('pathMigration')).$nameMigration;
		
			$classMigration = new $namespaceMigration();

			$classMigration->migrate();
			
			$output->writeln(sprintf('<info>Миграция: "%s" успешно выполнена.</info>', $input->getArgument('name')));
		}
		
		else
			$output->writeln(sprintf('<error>Миграция: "%s" не найдена.</error>', $input->getArgument('name')));
		
		return 1;
		
    }
	
}