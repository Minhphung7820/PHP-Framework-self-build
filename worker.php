<?php
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('QUEUE_GFW', false, false, false, false);

echo " [*] Waiting for queue job. To exit press CTRL+C\n";

$callback = function ($msg) {
    $classJob = $msg->body;
    $instanceJob = new $classJob();
    $instanceJob->handle();
    echo ' [x] Processed Job ', $msg->body, "\n";
};

$channel->basic_consume('QUEUE_GFW', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
