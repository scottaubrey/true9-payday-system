<?php

declare(strict_types=1);

describe('PayDayApi', function () {
    it('accepts a year and a month', function () {
        $responseData = makePayDayRequestAndDecode('2026', '10');

        expect($responseData)->not->toBeNull();
    });

    it('returns a pay date that is the second-to-last day of the month', function () {
        $payDayView = makePayDayRequestAndDecode('2026', '10');

        expect($payDayView?->payDate?->toString())->toEqual('2026-10-30');
    });

    it('returns a pay date that is the prior Friday if the second-to-last day is a weekend', function () {
        $payDayView = makePayDayRequestAndDecode('2026', '11');

        expect($payDayView?->payDate?->toString())->toEqual('2026-11-27');
    });

    it('returns a payment date that is four days before the pay date', function () {
        $payDayView = makePayDayRequestAndDecode('2026', '11');

        expect($payDayView?->paymentDate?->toString())->toEqual('2026-11-23');
    });

    it('returns a payment date that is does not count weekend days', function () {
        $payDayView = makePayDayRequestAndDecode('2026', '12');

        expect($payDayView?->paymentDate?->toString())->toEqual('2026-12-24');
    });

    it('returns an error with invalid dates', function (string $year, string $month) {
        makePayDayRequestAndExpectError($year, $month, 400, '400 Bad Request');
    })->with([
        ['2026', '13'],
        ['2026', 'abc'],
        ['abc', '12'],
    ]);
});
