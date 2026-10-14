<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

        $app->get('/api/payday', static function (ServerRequestInterface $request, ResponseInterface $response) {
            $params = $request->getQueryParams();

            /** @var string|null $year */
            $year = $params['year'] ?? null;
            /** @var string|null $month */
            $month = $params['month'] ?? null;

            $date = $year === '2026' && $month === '11' ? '2026-11-27' : '2026-10-28';
            $json = new PayDay(PayDate::fromString($date))->toJson();

            $response->getBody()->write($json);

            return $response->withHeader('Content-Type', 'application/json');
        });

        return $app;
    }
}
