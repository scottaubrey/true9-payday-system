<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Factory\AppFactory;

class Application
{
    public function getSlimApp(): App
    {
        $app = AppFactory::create();
        $app->get('/', static function (RequestInterface $_request, ResponseInterface $response) {
            $response->getBody()->write('Hello world!');
            return $response;
        });

        return $app;
    }
}
