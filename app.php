<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

chdir(__DIR__);
require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->get('/', function (RequestInterface $_request, ResponseInterface $response) {
    $response->getBody()->write('Hello world!');
    return $response;
});
$app->run();
