<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;
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
            $json = new PayDay(PayDate::fromString('2026-10-28'))->toJson();

            $response->getBody()->write($json);

            return $response->withHeader('Content-Type', 'application/json');
        });

        return $app;
    }
}
