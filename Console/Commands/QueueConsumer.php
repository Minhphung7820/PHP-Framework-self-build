<?php

namespace Console\Commands;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use ReflectionMethod;

class QueueConsumer
{
    public function timeQueue()
    {
        $timezone = 'Asia/Ho_Chi_Minh';
        \Carbon\Carbon::setLocale('vi');
        return new \Carbon\Carbon(null, $timezone);
    }

    public function run()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('QUEUE_GFW', false, false, false, false);

        echo "\e[33m [*] Waiting for queue job. To exit press CTRL+C\e[0m\n";

        $callback = function ($msg) {
            $data = unserialize($msg->body);
            echo "\e[33m" . ' [..] [' . $this->timeQueue() . '][' . explode(":",  $data[0])[1] . '] ' . explode(":",  $data[0])[0] . ' Processing' . "\e[0m\n";

            $classJob = explode(":",  $data[0])[0];

            if (strpos($classJob, 'App\Jobs\\') === 0) {
                $instanceJob = new $classJob(...$data[1]);
                $reflectionMethod = new ReflectionMethod($classJob, 'handle');
                $paramsToRun = [];
                $paramsHandle = $reflectionMethod->getParameters();
                foreach ($paramsHandle as $key => $param) {
                    if ($param->getType() !== null && !$param->getType()->isBuiltin()) {
                        $className = $param->getType()->getName();
                        $paramsToRun[] = (\Core\App::getContainer())->make($className);
                    }
                }
                $instanceJob->handle(...$paramsToRun);

                echo "\e[32m" . ' [OK] [' . $this->timeQueue() . '][' . explode(":",  $data[0])[1] . '] ' . explode(":",  $data[0])[0] . ' Processed' . "\e[0m\n";

                $msg->ack();
            } elseif (strpos($classJob, 'App\Listeners\\') === 0) {
                list($instanceEvent) = $data[1];
                $instanceJob = new $classJob();
                $reflectionMethod = new ReflectionMethod($classJob, 'handle');
                $paramsToRun = [];
                $paramsHandle = $reflectionMethod->getParameters();
                foreach ($paramsHandle as $key => $param) {
                    if ($param->getType() !== null && !$param->getType()->isBuiltin()) {
                        $className = $param->getType()->getName();
                        if ($className === get_class($instanceEvent)) {
                            $paramsToRun[$key] = $instanceEvent;
                        } else {
                            $paramsToRun[$key] = (\Core\App::getContainer())->make($className);
                        }
                    }
                }
                $instanceJob->handle(...$paramsToRun);

                echo "\e[32m" . ' [OK] [' . $this->timeQueue() . '][' . explode(":",  $data[0])[1] . '] ' . explode(":",  $data[0])[0] . ' Processed' . "\e[0m\n";

                $msg->ack();
            }
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
