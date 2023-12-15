# RabbitMQ Adapter Package

Description of your RabbitMQ adapter package.



## Installation

You can install the package via Composer:

```bash
composer require dreanarc/rabbitmq-adapter
```
## Usage/Examples

## PHP Native
If you're using PHP Native, follow these steps:

* Install composer
* Create PHP Project directory 
* Init PHP project using composer
* Install the package via composer
  ```bash
  composer require dreanarc/rabbitmq-adapter
  ```
* Code Example for Queue Producer
  ```php
  require 'vendor/autoload.php';

  use Dreanarc\RabbitMQAdapter\RabbitMQProducer;

  $producer = new RabbitMQProducer(
      'localhost',
      '5672',
      'guest',
      'guest'
  );

  $data = "";

  $producer->sendMessage('queue_name', $data);
  ```
* Code Example for Queue Consumer
  ```php
  require 'vendor/autoload.php';

  use Dreanarc\RabbitMQAdapter\RabbitMQConsumer;
  use PhpAmqpLib\Message\AMQPMessage;

  $consumer = new RabbitMQConsumer(
      'localhost',
      '5672',
      'guest',
      'guest'
  );

  $consumer->consume('queue_name', function(AMQPMessage $message){
      echo 'Received message: ', $message->getBody(), PHP_EOL;
  });
  ```

## Codeigniter 3.x
If you're using Codeigniter 3.x, follow these steps:

* Install the package via composer
  ```bash
  composer require dreanarc/rabbitmq-adapter
  ```
* create config file *application\config\rabbitmq.php*

    ```php
    <?php defined('BASEPATH') or exit('No direct script access allowed');

    $config['rabbitmq_host'] = 'localhost';
    $config['rabbitmq_port'] = 5672;
    $config['rabbitmq_user'] = 'guest';
    $config['rabbitmq_password'] = 'guest';
    ```
* Do not forget add **rabbitmq** in *application\config\autoload.php*
    ```php
    $autoload['config'] = array('rabbitmq');
    ```

* Create custom library *application\libraries\Rabbitmq_Adapter.php*
    ```php
    <?php

    use Dreanarc\RabbitMQAdapter\RabbitMQConsumer;
    use Dreanarc\RabbitMQAdapter\RabbitMQProducer;

    class Rabbitmq_Adapter
    {
        private $config;
        function __construct()
        {
            // Load CodeIgniter config
            $CI =& get_instance();

            $this->config['host'] = $CI->config->item('rabbitmq_host') ?: 'localhost';
            $this->config['port'] = $CI->config->item('rabbitmq_port') ?: 5672;
            $this->config['user']= $CI->config->item('rabbitmq_user') ?: 'guest';
            $this->config['password']= $CI->config->item('rabbitmq_password') ?: 'guest';
        }

        function publish_queue($queue_name, $msg){
            $producer = new RabbitMQProducer(
                $this->config['host'],
                $this->config['port'],
                $this->config['user'],
                $this->config['password']
            );

            try {
                $producer->sendMessage($queue_name, $msg);
                return true;
            } catch (Error $rr) {
                return false;
            }
        }

        function consume_queue($queue_name, callable $callback){
            $consumer = new RabbitMQConsumer(
                $this->config['host'],
                $this->config['port'],
                $this->config['user'],
                $this->config['password']
            );

            try {
                $consumer->consume($queue_name, $callback);
            } catch (Error $rr) {
                return false;
            }
        }
    }
    ```
* Code Example for Queue adapter
    ```php
    <?php

    use PhpAmqpLib\Message\AMQPMessage;

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Queue extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->library('Rabbitmq_Adapter', null, 'queue');
        }

        public function publish()
        {
            $this->queue->publish_queue('email.notification', 'tes queue');
        }

        public function consumer()
        {
            $this->queue->consume_queue('email.notification', function(AMQPMessage $message){
                echo 'Received message: ', $message->getBody(), PHP_EOL;
            });
        }
    } 
    ```

<!--
## Laravel
If you're using Laravel, follow these steps:

* sdasasd

```php

```

-->


## Demo

Insert gif or link to demo


## License

[MIT](https://choosealicense.com/licenses/mit/)

