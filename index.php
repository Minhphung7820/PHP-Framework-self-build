<?php
require './vendor/autoload.php';

use Core\App;
use Core\Bootstrap;
// khởi tạo servid  er provider
$bootstrap = new Bootstrap();

// Khởi tạo Router
$app = new App($_SERVER['REQUEST_URI']);
