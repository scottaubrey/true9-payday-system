<?php

declare(strict_types=1);

describe('PayDayApi', function () {
    it('accepts a year and a month', function () {
        $responseData = $this->makePayDayRequestAndDecode('2026', '10');

        expect($responseData)->not->toBeNull();
    })->throws(\Exception::class);
    todo('returns a pay date that is the second-to-last day of the month');
    todo('returns a pay date that is the prior Friday if the second-to-last day is a weekend');
    todo('returns a payment date that is four days before the pay date');
    todo('returns a payment date that is does not count weekend days');
});
