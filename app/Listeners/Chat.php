<?php

namespace App\Listeners;

use Workerman\Worker;
use PHPSocketIO\SocketIO;
use Workerman\Timer;
use Db;
use Session;
use Store;

class Chat
{
    
    /**
     * io
     *
     * @var mixed
     */
    private $io;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct($connect)
    {

        $this->io = $connect;

    }
    
    /**
     * execute
     *
     * @return void
     */
    public function execute()
    {

        $this->io->on('connection', function($socket) {
            $socket->on('data', function($data) use ($socket){
                Timer::add(1, function() use ($socket, $data){

                    $authUserid = $data['session'];
                    $userid = $data['userid'];
                    $sessionId = $data['sessionId'];

                    $messages = Db::getAll('SELECT * FROM chat WHERE fromId = ? OR toId = ?', [$userid, $userid]);

                    $lastMessage = array_pop($messages);

                    if(Session::getWithKey($sessionId, 'lastNumberMessage') != $lastMessage['id'])
                    {
                        Session::createWithKey($sessionId, 'lastNumberMessage', $lastMessage['id']);

                        $socket->emit('chat-message', $messages);
                    }
                });
            });
        });

        Worker::runAll();

    }

}