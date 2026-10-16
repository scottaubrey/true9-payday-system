<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;

function makePayDayRequestAndDecode(string $year, string $month): ?PayDay
{
    $response = makePayDayRequest($year, $month);

    //required before treating as a freshly received ResponseInterface;
    $response->getBody()->rewind();
    expect($response->getStatusCode())->toEqual(200);

    $body = $response->getBody()->getContents();
    expect($body)->not->toBeNull();
    return PayDay::fromJson($body);
}
