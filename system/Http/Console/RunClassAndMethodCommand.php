<?php

namespace System\Http\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RunClassAndMethodCommand extends Command
{
	
    protected static $defaultName = 'app:run_class';

    protected function configure()
    {
		
        $this->setDescription('Запускает класс и метод')
			->addArgument('namespace_class', InputArgument::REQUIRED, 'namespace к классу который запускается')
			->addOption('method', 'm', InputOption::VALUE_REQUIRED, 'Метод который запускается в классе', null);
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
		$status = false;
		
		if(!class_exists($input->getArgument('namespace_class')))
			$output->writeln(sprintf('<error>Класс: "%s" не найден.</error>', $input->getArgument('namespace_class')));
		else
		{
			$status = true;
			
			if(!method_exists($input->getArgument('namespace_class'), $input->getOption('method')))
			{
				$status = false;
				$output->writeln(sprintf('<error>Метод: "%s" в классе: "%s" не найден.</error>', $input->getOption('method'), $input->getArgument('namespace_class')));
			}
			else
				$status = true;
		}
		
		if($status === true)
		{
			$namespace = $input->getArgument('namespace_class');
			$method = $input->getOption('method');
			
			$class = new $namespace;
			
			$class->$method();
		}
		
		return 1;
		
    }
	
}