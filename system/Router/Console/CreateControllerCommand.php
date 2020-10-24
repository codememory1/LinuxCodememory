<?php

namespace System\Router\Console;

use System\Codememory\Console\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateControllerCommand extends Command
{
	
    protected static $defaultName = 'make:controller';

    protected function configure()
    {
		
        $this->setDescription('Создание контроллера')
			->addArgument('name', InputArgument::REQUIRED, 'Имя контроллера')
			->setHelp('Создает контроллер указав 1 аргумент "Имя контроллера"');
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
		$store = new Store();
		
		$getExampleController = file_get_contents('system/Router/Console/ControllerExample.sudo');
		$replaceExample = $store->replace(['%name' => $input->getArgument('name').'Controller'], $getExampleController);
		
		$create = file_put_contents('app/Controllers/'.$input->getArgument('name').'Controller.php', $replaceExample);
		
		($create) ? 
			$output->writeln(sprintf('<info>Контроллер "%s" создан.</info>', $input->getArgument('name'))) :
		$output->writeln('<error>Ошибка: контроллер не создан.</error>');
			
		return 1;
		
    }
	
}