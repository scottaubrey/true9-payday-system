<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PaymentDate;

describe('Model\PaymentDate', function () {
    describe('fromString', function () {
        it('throws with an invalid date string', function () {
            expect(fn() => PaymentDate::fromString(''))->toThrow(\Exception::class);
        });

        it('accepts a valid date string', function () {
            $dateString = '2026-10-14';
            $paymentDate = PaymentDate::fromString($dateString);
            expect($paymentDate)->toBeInstanceOf(PaymentDate::class);
        });
    });
    describe('toString', function () {
        it('returns a date string formatted YYYY-MM-DD', fails(function () {
            $dateString = '2026-10-14';
            $paymentDate = PaymentDate::fromString($dateString);
            expect($paymentDate->toString())->toBe($dateString);
        }));
    });
});
