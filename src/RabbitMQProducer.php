<?php

namespace Dreanarc\RabbitMQAdapter;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQProducer
{
    private $connection;
    private $channel;

    public function __construct($host, $port, $user, $password)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
    }

    public function sendMessage($queueName, $message)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

// For CodeIgniter 3 compatibility
if (!function_exists('get_instance')) {
    function get_instance()
    {
        return null;
    }
}
