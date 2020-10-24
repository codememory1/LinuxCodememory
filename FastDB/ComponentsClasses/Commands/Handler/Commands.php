<?php

namespace FastDB\ComponentsClasses\Commands\Handler;

use FastDB\ComponentsClasses\Commands\CommandInterface;
use FastDB\ComponentsClasses\Commands\Handler\Exceptions\InvalidCommandException;
use FastDB\ComponentsClasses\Commands\Handler\Exceptions\ErrorExecuteCommandException;
use FastDB\ComponentsClasses\Commands\Handler\InputCommand;
use System\Database\FastDB\FunctionalDatabase\Connection;
use Store;

/**
 * Commands
 */
class Commands
{
    
    /**
     * command
     *
     * @var array
     */
    private $command = [];
    
    /**
     * commandString
     *
     * @var array
     */
    private $commandString = [];
    
    /**
     * required
     *
     * @var array
     */
    private $required = [];
    
    /**
     * options
     *
     * @var array
     */
    private $options = [];
    
    /**
     * commandFull
     *
     * @var array
     */
    private $commandFull = [];
    
    /**
     * values
     *
     * @var array
     */
    private $values = [];
            
    /**
     * query
     *
     * @var mixed
     */
    private $query;
    
    /**
     * __construct
     *
     * @param  mixed $query
     * @return void
     */
    public function __construct($query = null)
    {
        
        $this->query = $query;

    }

    /**
     * getQuery
     *
     * @return void
     */
    public function getQuery()
    {

        return $this->query;

    }

    /**
     * registration
     *
     * @param  mixed $comamand
     * @return void
     */
    public function registration(CommandInterface $comamand)
    {

        $this->command[] = $comamand;

    }
    
    /**
     * setCommand
     *
     * @param  mixed $cmd
     * @return void
     */
    public function setCommand(string $cmd)
    {

        $this->commandString[] = $cmd;
        
        return $this;

    }
    
    /**
     * setRequired
     *
     * @param  mixed $position
     * @return void
     */
    public function setRequired(string $position)
    {

        $this->required[] = '%'.$position;

        return $this;

    }
    
    /**
     * setOptions
     *
     * @param  mixed $position
     * @param  mixed $prevText
     * @param  mixed $required
     * @return void
     */
    public function setOptions(string $position, ?string $prevText = null, bool $required = true)
    {

        $this->options['position'][] = '%'.$position;
        $this->options['prevText'][] = $prevText;
        $this->options['required'][] = $required;

        return $this;

    }

    /**
     * setValues
     *
     * @param  mixed $position
     * @param  mixed $prevText
     * @param  mixed $required
     * @return void
     */
    public function setValues(string $position, ?string $prevText = null, bool $required = true)
    {

        $this->values['position'][] = '%'.$position;
        $this->values['prevText'][] = $prevText;
        $this->values['required'][] = $required;

        return $this;
        
    }
    
    /**
     * commands
     *
     * @param  mixed $commands
     * @return void
     */
    private function commands($commands)
    {

        foreach($commands as $k => $command)
        {
            $cmd = $command['command'];
            $cmd = '/^'.preg_quote($cmd, '/').'$/';
            $cmd = preg_replace('/(?:\s+)?(\%([a-z\_\-]+))(?:\s+)?/', '(?:\s+)?$1(?:\s+)?', $cmd);
            $options = $command['handler']->options;
            $required = $command['handler']->required;
            $values = $command['handler']->values;

            if(count($required) > 0)
            {
                foreach($required as $k => $requiredOpt)
                {
                    $cmd = Store::replace([$requiredOpt => '\`(?<'.trim($requiredOpt, '%').'>.*)\`'], $cmd);
                }
            }

            $cmd = $this->commonComponent($options, '{', '}', $cmd);
            $cmd = $this->commonComponent($values, '(', ')', $cmd);

            $this->commandFull[] = $cmd;
        }

    }
    
    /**
     * commonComponent
     *
     * @param  mixed $data
     * @param  mixed $symbolStart
     * @param  mixed $symbolEnd
     * @param  mixed $cmd
     * @return void
     */
    private function commonComponent(array $data, string $symbolStart, string $symbolEnd, string $cmd)
    {

        if(count($data) > 0)
        {
            foreach($data['position'] as $k => $replaceOpt)
            {
                if($data['required'][$k] === true)
                {
                    $cmd = Store::replace([$replaceOpt => $data['prevText'][$k].'\\'.$symbolStart.'(?<'.trim($replaceOpt, '%').'>.*)\\'.$symbolEnd], $cmd);
                }
                if($data['required'][$k] === false)
                {
                    $cmd = Store::replace([$replaceOpt => '(()|'.$data['prevText'][$k].'\\'.$symbolStart.'(?<'.trim($replaceOpt, '%').'>.*)\\'.$symbolEnd.')'], $cmd);
                }
            }
        }

        return $cmd;

    }
    
    /**
     * renderCommand
     *
     * @return void
     */
    private function renderCommand()
    {

        if(count($this->command) > 0) 
        {
         
            $commands = [];

            foreach($this->command as $key => $command)
            {
                $command->configurate();

                $commands[] = [
                    'command' => $command->commandString[0],
                    'handler' => $command
                ];
            }

            $this->commands($commands);

        }

    }
    
    /**
     * executeCommand
     *
     * @param  mixed $command
     * @return void
     */
    public function executeCommand(string $command)
    {
        $command = $command;
        $this->renderCommand();

        $keyCommand = null;
        $match = [];

        foreach($this->commandFull as $keyCmd => $matchCmd)
        {
            if(preg_match_all($matchCmd, $command, $matches) === 1)
            {
                $keyCommand = $keyCmd;
                $match = $matches;
            }
        }

        foreach($match as $k => $matches)
        {
            if(is_numeric($k)) unset($match[$k]);
        }
        
        if($keyCommand === null) throw new InvalidCommandException(debug_backtrace());
        else
        {
            $execute = $this->command[$keyCommand]->execute(new InputCommand($match));

            if($execute === false) throw new ErrorExecuteCommandException(debug_backtrace());
            else return $execute;
        }
        
    }
    

}