<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Service\PayDateCalculator;

describe('Service\PayDateCalculator', function () {
    it('returns a pay date that is the second-to-last day of the month', fails(function () {
        $payDateCalculator = new PayDateCalculator();

        $payDate = $payDateCalculator->calculateFor('2026', '09');

        expect($payDate->toString())->toBe('2026-09-29');
    }));
    todo('returns a pay date that is the prior Friday if the second-to-last day is a weekend');
});
