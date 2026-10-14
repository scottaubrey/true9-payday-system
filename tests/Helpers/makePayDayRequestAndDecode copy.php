<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Application;
use Slim\Psr7\Factory\ServerRequestFactory;
use Uri\Rfc3986\Uri;

function makePayDayRequestAndExpectError(
    string $year,
    string $month,
    int $expectedStatusCode,
    string $expectedMessage,
): void {
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
    expect($response->getStatusCode())->toEqual($expectedStatusCode);

    $body = $response->getBody()->getContents();
    expect($body)->not->toBeNull();

    /** @var array{message: string} */
    $error = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
    expect($error['message'])->toBe($expectedMessage);
}
