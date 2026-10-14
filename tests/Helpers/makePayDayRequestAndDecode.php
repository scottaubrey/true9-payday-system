<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Application;
use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;
use Slim\Psr7\Factory\ServerRequestFactory;
use Uri\Rfc3986\Uri;

function makePayDayRequestAndDecode(string $year, string $month): PayDay
{
    $app = new Application()->getSlimApp();
    $serverRequestFactory = new ServerRequestFactory();
    $uri = new Uri('/api/payday')->withQuery(http_build_query(['year' => $year, 'month' => $month]));
    $request = $serverRequestFactory->createServerRequest('GET', $uri->toString());
    $response = $app->handle($request);

    //required before treating as a freshly received ResponseInterface;
    $response->getBody()->rewind();
    expect($response->getStatusCode())->toEqual(200);

    $body = $response->getBody()->getContents();
    expect($response->getStatusCode())->not->toBeNull();

    return PayDay::fromJson($body);
}
