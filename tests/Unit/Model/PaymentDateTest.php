<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PaymentDate;

describe('Model\PaymentDate', function () {
    describe('fromString', function () {
        it('throws with an invalid date string', fails(function () {
            expect(fn() => PaymentDate::fromString(''))->toThrow(\Exception::class);
        }));

        todo('accepts a valid date string');
    });
    describe('toString', function () {
        todo('returns a date string formatted YYYY-MM-DD');
    });
});
