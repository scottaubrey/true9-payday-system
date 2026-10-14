<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PayDate;

describe('PayDayApi', function () {
    it('accepts a year and a month', function () {
        $responseData = makePayDayRequestAndDecode('2026', '10');

        expect($responseData)->not->toBeNull();
    });

    it('returns a pay date that is the second-to-last day of the month', function () {
        $payDayView = makePayDayRequestAndDecode('2026', '10');

        expect($payDayView->payDate)->toBe(PayDate::fromString('2026-10-28'));
    })->fails();

    todo('returns a pay date that is the prior Friday if the second-to-last day is a weekend');
    todo('returns a payment date that is four days before the pay date');
    todo('returns a payment date that is does not count weekend days');
});
