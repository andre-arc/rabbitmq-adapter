# RabbitMQ Adapter Package

RabbitMQ adapter package For PHP.



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
* Usage Code Example for Queue Producer
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
* Usage Code Example for Queue Consumer
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
<!--
## Laravel
If you're using Laravel, follow these steps:

* sdasasd

```php

```

## Codeigniter 3.x
If you're using Codeigniter 3.x, follow these steps:

* sdasasd

```php

```
-->


## Demo

Insert gif or link to demo


## License

[MIT](https://choosealicense.com/licenses/mit/)

