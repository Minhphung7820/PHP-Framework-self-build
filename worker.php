<?php
require __DIR__ . '/vendor/autoload.php';

use Console\Commands\QueueConsumer;

(new QueueConsumer())->run();
