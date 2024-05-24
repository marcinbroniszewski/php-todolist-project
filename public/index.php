<?php

require __DIR__ . '/../helpers.php';
require basePath('vendor/autoload.php');

use Framework\Router;

$router = new Router();

require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);