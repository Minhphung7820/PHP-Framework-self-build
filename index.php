<?php

/**
 * GalaxyFW - A PHP Framework For Web
 *
 * @package  GalaxyFW
 * @author   Truong Minh Phung <minhphung485@gmail.com>
 */
require __DIR__ . '/vendor/autoload.php';

use Bootstrap\Bootstrap;

/**
 * This is the project start file
 * where the providers are initialized.
 */
$bootstrap = new Bootstrap();
$bootstrap->run();
