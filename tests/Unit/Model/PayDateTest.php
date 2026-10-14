<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PayDate;

describe('Model\PayDate', function () {
    describe('fromString', function () {
        it('throws with an invalid date string', fails(function () {
            expect(fn() => PayDate::fromString(''))->toThrow(\Exception::class);
        }));
        todo('returns a PayDate with internal value for the given date string');
    });
});
