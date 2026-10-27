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
use Slim\Routing\RouteCollectorProxy;

class Application
{
    public function getSlimApp(): App
    {
        $app = AppFactory::create();
        $app->get('/', static function (RequestInterface $_request, ResponseInterface $response) {
            $body = '<p>This is the True9 Payday system API server.</p><p><small>If you were expecting an application frontend, maybe you need to build the frontend first.</small></p>';
            if (file_exists('public/index.html')) {
                /** @var string $body */
                $body = file_get_contents('public/index.html');
            }
            $response->getBody()->write($body);
            return $response;
        });

        $app->group('/api', static function (RouteCollectorProxy $group) {
            $group->get('/payday', static function (ServerRequestInterface $request, ResponseInterface $response) {
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

                return $response;
            });
        })->addMiddleware(new class implements MiddlewareInterface {
            #[\Override]
            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler,
            ): ResponseInterface {
                $response = $handler->handle($request);
                if ($response->getHeaderLine('Content-Type') === '') {
                    $response = $response->withHeader('Content-Type', 'application/json');
                }
                return $response;
            }
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
