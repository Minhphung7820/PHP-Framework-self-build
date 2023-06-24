<?php

namespace Supports\Facades\Traits;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

trait Dispatchable
{
    public static function dispatchNow(...$args)
    {
        $nameJob = get_called_class() . ":" . bin2hex(random_bytes(32));
        // Kết nối tới RabbitMQ
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        // Khai báo một hàng đợi
        $channel->queue_declare("QUEUE_GFW", false, false, false, false);

        // Gửi một tác vụ vào hàng đợi
        $data = array($nameJob, $args);
        $message = new AMQPMessage(json_encode($data, true));
        $channel->basic_publish($message, '',  "QUEUE_GFW");

        // echo "Sent `$nameJob` to the task_queue.\n";

        // Đóng kết nối
        $channel->close();
        $connection->close();
    }
}
