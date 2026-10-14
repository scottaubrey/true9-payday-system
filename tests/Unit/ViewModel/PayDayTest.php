<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;

describe('ViewModel\PayDay', function () {
    describe('fromJson', function () {
        it('throws with an invalid json string', function () {
            expect(fn() => PayDay::fromJson('Invalid JSON'))->toThrow(Exception::class);
        });

        todo('maps a date string in YYYY-MM-DD format to a PayDate');
    });
});
