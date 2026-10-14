<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Application;
use Slim\Psr7\Factory\ServerRequestFactory;
use Uri\Rfc3986\Uri;

/**
 * @return null|array<string, string>
 */
function makePayDayRequestAndDecode(string $year, string $month): ?array
{
    $app = new Application()->getSlimApp();
    $serverRequestFactory = new ServerRequestFactory();
    $uri = new Uri('/api/payday')->withQuery(http_build_query(['year' => $year, 'month' => $month]));
    $request = $serverRequestFactory->createServerRequest('GET', $uri->toString());
    $response = $app->handle($request);

    //required before treating as a freshly received ResponseInterface;
    $response->getBody()->rewind();

    if ($response->getStatusCode() !== 200) {
        return null;
    }

    $body = $response->getBody()->getContents();
    if ($body === '') {
        return null;
    }

    /** @var array<string, string> */
    return json_decode($body, true);
}
