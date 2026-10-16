<?php

declare(strict_types=1);

function makePayDayRequestAndExpectError(
    string $year,
    string $month,
    int $expectedStatusCode,
    string $expectedMessage,
): void {
    $response = makePayDayRequest($year, $month);

    //required before treating as a freshly received ResponseInterface;
    $response->getBody()->rewind();
    expect($response->getStatusCode())->toEqual($expectedStatusCode);

    $body = $response->getBody()->getContents();
    expect($body)->not->toBeNull();

    /** @var array{message: string} */
    $error = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
    expect($error['message'])->toBe($expectedMessage);
}
