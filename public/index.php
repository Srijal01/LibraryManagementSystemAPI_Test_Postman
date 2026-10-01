<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (PHP_SAPI === 'cli-server') {
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $staticFile = __DIR__.$requestPath;

    if ($requestPath !== '/' && is_file($staticFile)) {
        return false;
    }
}

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
