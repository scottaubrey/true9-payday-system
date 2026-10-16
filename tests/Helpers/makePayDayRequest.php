<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Scottaubrey\True9PaydaySystem\Application;
use Slim\Psr7\Factory\ServerRequestFactory;
use Uri\Rfc3986\Uri;

function makePayDayRequest(string $year, string $month): ResponseInterface
{
    $app = new Application()->getSlimApp();
    $serverRequestFactory = new ServerRequestFactory();
    $uri = new Uri('/api/payday')->withQuery(http_build_query(['year' => $year, 'month' => $month]));
    $request = $serverRequestFactory->createServerRequest('GET', $uri->toString())->withHeader(
        'Accept',
        'application/json',
    );
    $response = $app->handle($request);

    //required before treating as a freshly received ResponseInterface;
    $response->getBody()->rewind();

    return $response;
}
