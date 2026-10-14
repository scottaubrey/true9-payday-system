<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\Service\PayDateCalculator;

describe('Service\PayDateCalculator', function () {
    describe('calculateFor', function () {
        it('returns a pay date that is the second-to-last day of the month', function () {
            $payDateCalculator = new PayDateCalculator();

            $payDate = $payDateCalculator->calculateFor('2026', '09');

            expect($payDate->toString())->toBe('2026-09-29');
        });

        it('returns a pay date that is the prior Friday if the second-to-last day is a weekend', function () {
            $payDateCalculator = new PayDateCalculator();

            $payDate = $payDateCalculator->calculateFor('2026', '08');

            expect($payDate->toString())->toBe('2026-08-28');
        });

        it('returns an error if the year and month create invalid dates', fails(function () {
            $payDateCalculator = new PayDateCalculator();

            expect(fn() => $payDateCalculator->calculateFor('2026', '13'))
                ->toThrow('Year (2026) and Month (13) are not valid.');
        }));
    });

    describe('calculatePaymentDateFor', function () {
        it('returns a payment date that is four days less than the payment date', function () {
            $payDateCalculator = new PayDateCalculator();

            $payDate = $payDateCalculator->calculatePaymentDateFor(PayDate::fromString('2026-08-28'));

            expect($payDate->toString())->toBe('2026-08-24');
        });

        it('returns a payment date taking into account working days before the payment date', function () {
            $payDateCalculator = new PayDateCalculator();

            $payDate = $payDateCalculator->calculatePaymentDateFor(PayDate::fromString('2026-09-29'));

            expect($payDate->toString())->toBe('2026-09-23');
        });
    });
});
