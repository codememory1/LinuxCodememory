<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Connect;

class CreateFileMigrationCommand extends Command
{
	
    protected static $defaultName = 'fastdb:create-migration';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {

        $this->setDescription('Creating migration file')
            ->addArgument('name', InputArgument::REQUIRED, 'Migration Name');
		
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
        
        $io = new SymfonyStyle($input, $output);
        $connect = new Connect(getcwd().'\settings-fastdb.xml');

        if(!$connect->getSettings()) {
            $io->error('Settings file not found');

            exit();
        }

        $migrationPath = $connect->getSettings()->paths->migration['path'];
        $pathExamples = dirname(__FILE__, 2).'\ExampleDocuments';
        $fullNameMigration = sprintf('M%s_%s', date('Y_m_d_H_i_s'), $input->getArgument('name')); 
        $namespace = $connect->getSettings()->handler->namespace['name'];
        $methodExec = $connect->getSettings()->handler->methodExecute['name'];

        $sudoMigration = sprintf(file_get_contents($pathExamples.'\Migration.example.sudo'), $namespace, $fullNameMigration, $namespace, $fullNameMigration, $methodExec);

        $io->definitionList([
            'name' => $fullNameMigration
        ]);
        
        if($io->confirm('Продолжить создание?')) {
            file_put_contents(getcwd().str_replace('/', '\\', $migrationPath).$fullNameMigration.'.php', $sudoMigration);

            $io->success('Migration created. Migration name: '.$fullNameMigration);
        }

		return 1;
		
    }

}