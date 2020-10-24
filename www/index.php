<?php

$common_php_dir = '../php_common';
$common_autoload_file = $common_php_dir.'/autoload.php';
require($common_autoload_file);

use web\mvc\router;
use common\errors\ExceptionHandler;
use common\logging\Logger;
use web\Config;

$exh = new ExceptionHandler();
$exh->setHandler();

Config::obj(__DIR__ . '/config/config.ini');

$wr = new router\WebRouter();

if (!empty(Config::obj()->routes)) {
    $wr->routes = Config::obj()->routes;
} else if (Config::obj()->project !== null) {
    $routeFile = './project/'.Config::obj()->project.'/routes.php';
    if (file_exists($routeFile)) {
        $wr->routes = require($routeFile);
    }
} else {
    throw new RuntimeException('No routes have been configured', 55);
}

$wr->run();