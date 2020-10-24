<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Connect;

class MigrationsListingCommand extends Command
{
	
    protected static $defaultName = 'fastdb:listing';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {

        $this->setDescription('Migrations Listing');
		
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
            $io->error('Файл настроек не найден');

            exit();
        }

        $migrationPath = $connect->getSettings()->paths->migration['path'];
        $migrationPath = getcwd().str_replace('/', '\\', $migrationPath);
        $scan = array_diff(scandir($migrationPath), ['.', '..']);

        $migrations = [];

        foreach($scan as $key => $migration)
        {
            if(is_file($migrationPath.$migration)) {
                $stat = stat($migrationPath.$migration);

                preg_match('/M[0-9]{4}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_[0-9]{2}\_(.*)\.php/', $migration, $match);

                $migrations[] = [
                    $key,
                    $match[1],
                    $migration,
                    $stat[7].' B',
                    date("F d Y H:i:s.", filectime($migrationPath.$migration))
                ];
            }
        }

        $io->table(
            ['№', 'name', 'full_name', 'size', 'date_created'],
            $migrations
        );

		return 1;
		
    }

}