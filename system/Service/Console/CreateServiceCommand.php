<?php

namespace System\Service\Console;

use System\Codememory\Console\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateServiceCommand extends Command
{
	
    protected static $defaultName = 'make:service';

    protected function configure()
    {
		
        $this->setDescription('Создание сервиса')
			->addArgument('name', InputArgument::REQUIRED, 'Имя сервиса')
			->addArgument('namespace', InputArgument::REQUIRED, 'namespace - сервис чего');
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
		$nameService = 'Service'.one_up_line($input->getArgument('name'));
		
		$arrayNamespace = explode('\\', $input->getArgument('namespace'));
		
		$store = new Store();
		
		$object = array_pop($arrayNamespace);
		$varPublic = down_line($object);
		
		$getExample = file_get_contents('system/Service/Console/ServiceExample.sudo');
		
		$dataExampleService = $store->replace(
			[
				'%name' 	   => $nameService, 
			 	'%patch_class' => $input->getArgument('namespace'), 
				'%var_public'  => $varPublic, 
				'%object' 	   => $object
			],
			$getExample
		);
		
		$create = file_put_contents('system/Service/'.$nameService.'.php', $dataExampleService);
		
		($create) ? 
			$output->writeln(sprintf('<info>Сервис "%s" создан.</info>', $nameService)) :
		$output->writeln('<error>Ошибка: сервис не создан.</error>');
		
		return 1;
		
    }
	
}