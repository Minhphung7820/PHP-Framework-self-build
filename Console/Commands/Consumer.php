<?php

namespace Console\Commands;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use ReflectionMethod;

class Consumer
{
    public function run()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('QUEUE_GFW', false, false, false, false);

        echo "\e[1;33m [*] Waiting for queue job. To exit press CTRL+C\e[0m\n";

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $classJob = explode(":",  $data[0])[0];
            $instanceJob = new $classJob(...$data[1]);
            $reflectionMethod = new ReflectionMethod($classJob, 'handle');
            $paramsToRun = [];
            $paramsHandle = $reflectionMethod->getParameters();
            foreach ($paramsHandle as $param) {
                if ($param->getType() !== null && !$param->getType()->isBuiltin()) {
                    $instance = $param->getType()->getName();
                    $paramsToRun[] = (\Core\App::getContainer())->make($instance);
                }
            }
            $instanceJob->handle(...$paramsToRun);
            echo "\e[1;32m" . ' [OK] Processed Job ' . $data[0] . "\e[0m\n";

            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('QUEUE_GFW', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
