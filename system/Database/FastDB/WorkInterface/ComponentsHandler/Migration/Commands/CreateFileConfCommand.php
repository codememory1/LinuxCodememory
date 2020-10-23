<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateFileConfCommand extends Command
{
	
    protected static $defaultName = 'fastdb:create-conf';
    
    /**
     * configure
     *
     * @return void
     */
    protected function configure()
    {

        $this->setDescription('Creating a configuration file for database management');
		
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
        $io->title('
            Small account configuration settings for working with migrations.
        ');

        $filename = 'settings-fastdb.xml';
        $pathExamples = dirname(__FILE__, 2).'\ExampleDocuments';
        
        if(file_exists('settings-fastdb.xml')) {
            $isConfirm = $io->confirm('Файл существует. Хотите пересоздать?');

            if($isConfirm === true) $this->createFileConfiguration($filename, $io, $pathExamples);
        } else {
            $this->createFileConfiguration($filename, $io, $pathExamples);
        }

		return 1;
		
    }
        
    /**
     * createFileConfiguration
     *
     * @param  mixed $filename
     * @param  mixed $io
     * @param  mixed $example
     * @return void
     */
    private function createFileConfiguration(string $filename, $io, $example)
    {   
        
        $config = file_get_contents($example.'\Settings.example.sudo');

        $server = $io->ask('Specify the server ip', null, function($ip) {
            if(!preg_match('/[0-9]{3}\.[0-9]{3}\.[0-9]{2}\.[0-9]{2}\.[0-9]{1}/', $ip)) {
                throw new \RuntimeException('Invalid Server ip. Example: 000.000.00.00.0');
            }

            return $ip;
        });
        $port = $io->ask('Specify the server port', null, function($port) {
            if(!is_numeric($port)) {
                throw new \RuntimeException('Invalid Server port. Example: 0000');
            }

            return $port;
        });
        $login = $io->ask('Username', null, function($login) {
            if(!preg_match('/^[a-z0-9\_]+$/i', $login)) {
                throw new \RuntimeException('Invalid Username. Example: /^[a-z0-9\_]+$/i');
            }

            return $login;
        });
        $password = $io->askHidden('Password default (null)') ?? 'null';
        
        $config = preg_replace([
            '/(\<server\>)/',
            '/(\<port\>)/',
            '/(\<username\>)/',
            '/(\<password\>)/',
        ], [
            '<server>'.$server,
            '<port>'.$port,
            '<username>'.$login,
            '$1*****'
        ], $config);

        $isOk = $io->confirm($config.PHP_EOL.' is okay?');

        if($isOk) {
            $config = str_replace('*****', $password, $config);

            file_put_contents($filename, $config);
        }
        
        $io->success('Configuration file successfull create.');

    }

}