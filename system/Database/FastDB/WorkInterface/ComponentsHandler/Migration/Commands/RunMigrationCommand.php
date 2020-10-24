<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Connect;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * RunMigrationCommand
 */
class RunMigrationCommand extends Command
{
	
    protected static $defaultName = 'fastdb:run';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {

        $this->setDescription('Migrations run')
            ->addArgument('name', InputArgument::REQUIRED, 'Название миграции');
		
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
        $connect = new Connect(getcwd().'/settings-fastdb.xml');

        if(!$connect->getSettings()) {
            $io->error('Файл настроек не найден');

            exit();
        }

        $migrationPath = $connect->getSettings()->paths->migration['path'];
        $migrationPath = getcwd().str_replace('\\', '/', $migrationPath);
        $scan = array_diff(scandir($migrationPath), ['.', '..']);
        $namespace = $connect->getSettings()->handler->namespace['name'];
        $methodExec = $connect->getSettings()->handler->methodExecute['name'];

        $migrations = [];

        foreach($scan as $key => $migration)
        {
            if(is_file($migrationPath.$migration)) {
                if(preg_match(sprintf('/M[0-9]{4}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_%s\.php/', $input->getArgument('name')), $migration)) {
                    $migrations[] = $migration;
                }
            }
        }   

        if(count($migrations) > 1) {
            $migration = $io->choice('Найдено несколько совпадений. Укажите номер миграции', $migrations);  
            $migrationNamespace = substr($namespace.'\\'.$migration, 0, -4);

            $this->executeMigration(new $migrationNamespace(), $methodExec, $io);
        } else {
            $namespaceMigration = substr($namespace.'\\'.$migrations[0], 0, -4);

            $this->executeMigration(new $namespaceMigration(), $methodExec, $io);
        }

		return 1;
		
    }

    private function executeMigration($migration, string $method, $io)
    {

        $statusRequest = $migration->$method();

        if($statusRequest === true) $io->success('Migration successfull executer.');
        else $io->error($statusRequest['message']);

    }

}