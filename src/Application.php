<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scottaubrey\True9PaydaySystem\Service\PayDateCalculator;
use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;
use Slim\App;
use Slim\Exception\HttpBadRequestException;
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

            if (!is_string($year) || !is_string($month)) {
                $response->getBody()->write('{"message":"Query params require strings"}');
                return $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            }

            $payDateCalculator = new PayDateCalculator();
            $payDate = $payDateCalculator->calculateFor($year, $month);
            $paymentDate = $payDateCalculator->calculatePaymentDateFor($payDate);

            $json = new PayDay($payDate, $paymentDate)->toJson();

            $response->getBody()->write($json);

            return $response->withHeader('Content-Type', 'application/json');
        });

        $app->addMiddleware(new class implements MiddlewareInterface {
            #[\Override]
            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler,
            ): ResponseInterface {
                try {
                    return $handler->handle($request);
                } catch (\DomainException $e) {
                    throw new HttpBadRequestException($request, previous: $e);
                }
            }
        });

        $app->addErrorMiddleware(false, false, false);

        return $app;
    }
}
