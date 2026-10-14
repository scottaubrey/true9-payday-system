<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PayDate;

describe('Model\PayDate', function () {
    describe('string serialisation', function () {
        it('throws with an invalid date string', function () {
            expect(fn() => PayDate::fromString(''))->toThrow(\Exception::class);
        });

        it('returns a PayDate with internal value for the given date string', function () {
            $dateString = '2026-10-14';
            $payDate = PayDate::fromString($dateString);
            expect($payDate)->toBeInstanceOf(PayDate::class);
            expect($payDate->toString())->toBe($dateString);
        });
    });
    describe('toDateTimeImmutable', function () {
        todo('returns a DateTimeImmutable object from internal representation');
    });
});
