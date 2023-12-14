<?php

namespace RabbitMQAdapter;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConsumer
{
    private $connection;
    private $channel;

    public function __construct($host, $port, $user, $password)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
    }

    public function consume($queueName, $callback)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
