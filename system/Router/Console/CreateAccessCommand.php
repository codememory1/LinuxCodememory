<?php

namespace System\Router\Console;

use System\Codememory\Console\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateAccessCommand extends Command
{
	
    protected static $defaultName = 'make:access';

    protected function configure()
    {
		
        $this->setDescription('Создание Access(доступ)')
			->addArgument('name', InputArgument::REQUIRED, 'Имя Access')
			->setHelp('Создает Access указав 1 аргумент "имя access"');
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
		$store = new Store();
		
		$getExampleController = file_get_contents('system/Router/Console/AccessExample.sudo');
		$replaceExample = $store->replace(['%ACCESS_NAME' => $input->getArgument('name').'Access'], $getExampleController);
		
		$create = file_put_contents('access/'.$input->getArgument('name').'Access.php', $replaceExample);
		
		($create) ? 
			$output->writeln(sprintf('<info>Access "%s" создан.</info>', $input->getArgument('name'))) :
		$output->writeln('<error>Ошибка: access не создан.</error>');
			
		return 1;
		
    }
	
}