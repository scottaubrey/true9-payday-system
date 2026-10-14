<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\Model\PaymentDate;
use Scottaubrey\True9PaydaySystem\ViewModel\PayDay;

describe('ViewModel\PayDay', function () {
    describe('fromJson', function () {
        it('throws with an invalid json string', function () {
            expect(fn() => PayDay::fromJson('Invalid JSON'))->toThrow(Exception::class);
        });

        it('maps a date string in YYYY-MM-DD format to a PayDate', function () {
            $payDayView = PayDay::fromJson('{"payDate":"2026-10-28"}');

            expect($payDayView->payDate)->toEqual(PayDate::fromString('2026-10-28'));
        });

        it('maps a date string in YYYY-MM-DD format to a PaymentDate', function () {
            $payDayView = PayDay::fromJson('{"payDate":"2026-10-28","paymentDate":"2026-10-23"}');

            expect($payDayView->paymentDate)->toEqual(PaymentDate::fromString('2026-10-23'));
        });
    });

    describe('toJson', function () {
        it('maps a PayDate string in YYYY-MM-DD format to a PayDate', function () {
            $payDayView = new PayDay(PayDate::fromString('2026-10-28'));

            expect($payDayView->toJson())->toEqual('{"payDate":"2026-10-28"}');
        });

        it('maps a paymentDate string in YYYY-MM-DD format to a PaymentDate', function () {
            $payDayView = new PayDay(PayDate::fromString('2026-10-28'), PaymentDate::fromString('2026-10-23'));

            expect($payDayView->toJson())->toEqual('{"payDate":"2026-10-28","paymentDate":"2026-10-23"}');
        });
    });
});
