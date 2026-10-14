<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem;

use Fig\Http\Message\StatusCodeInterface;
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

        $app->get('/api/payday', static function (RequestInterface $_request, ResponseInterface $response) {
            $json = json_encode(['payDate' => '2026-10-28']);
            if (!is_string($json)) {
                return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
            }
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        });

        return $app;
    }
}
