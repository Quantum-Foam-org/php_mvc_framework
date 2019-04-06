<?php

use mvc\router as router;

$common_php_dir = '../php_common';
$common_autoload_file = $common_php_dir.'/autoload.php';
require($common_autoload_file);

\web\Config::obj(__DIR__ . '/config/config.ini');

$wr = new router\WebRouter();

if (!empty(\web\Config::obj()->routes)) {
    $wr->routes = \web\Config::obj()->routes;
} else if (\web\Config::obj()->project !== null) {
    $routeFile = './project/'.\web\Config::obj()->project.'/routes.php';
    if (file_exists($routeFile)) {
        $wr->routes = require($routeFile);
    }
}

$wr->run();