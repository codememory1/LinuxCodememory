<?php

namespace System\Database\FastDB\FunctionalDatabase;

class Client
{

    const SERVER = 'myDb.loc/fastdb/';
    const URIEXECUTE = 'anonymous/execute/command/';
    
    /**
     * request
     *
     * @param  mixed $server
     * @param  mixed $command
     * @return void
     */
    public function request($server, $command)
    {

        $curl = curl_init(self::SERVER.self::URIEXECUTE.'?'.$server);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_DEFAULT_PROTOCOL, 'http');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, 'command='.$command);
        $reply = curl_exec($curl);
        curl_close($curl);
        
		$checkJson = is_string($reply) && is_array(json_decode($reply, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
		
		if($checkJson === true)
            return json_decode($reply, true);
        else if($reply == 'null')
            return true;
        else
            echo $reply;

    }

}