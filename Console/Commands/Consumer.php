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
            $classJob = $msg->body;
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
            echo ' [OK] Processed Job ', $classJob, "\n";
        };

        $channel->basic_consume('QUEUE_GFW', '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
