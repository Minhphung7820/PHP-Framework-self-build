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

        echo " [*] Waiting for queue job. To exit press CTRL+C\n";

        $callback = function ($msg) {
            $classJob = explode(":", $msg->body)[0];
            $instanceJob = new $classJob();
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
            echo ' [OK] Processed Job ', $msg->body, "\n";

            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('QUEUE_GFW', '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
