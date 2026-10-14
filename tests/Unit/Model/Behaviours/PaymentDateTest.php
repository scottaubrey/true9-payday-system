<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Model\Behaviours\DateValue;

// @mago-expect lint:file-name
class DateValueDummy
{
    use DateValue;
}

describe('Model\Behaviours\DateValue', function () {
    describe('fromString', function () {
        it('throws with an invalid date string', function () {
            expect(fn() => DateValueDummy::fromString(''))->toThrow(\Exception::class);
        });

        it('accepts a valid date string', function () {
            $dateString = '2026-10-14';
            $dateValueObject = DateValueDummy::fromString($dateString);
            expect($dateValueObject)->toBeInstanceOf(DateValueDummy::class);
        });

        it('throws with an overflow date string', fails(function () {
            expect(fn() => DateValueDummy::fromString('2026-13-01'))
                ->toThrow('2026-13-01 is not a valid date in the YYYY-MM-DD format');
        }));
    });
    describe('toString', function () {
        it('returns a date string formatted YYYY-MM-DD', function () {
            $dateString = '2026-10-14';
            $dateValueObject = DateValueDummy::fromString($dateString);
            expect($dateValueObject->toString())->toBe($dateString);
        });
    });
    describe('toDateTimeImmutable', function () {
        it('returns a DateTimeImmutable object from internal representation', function () {
            $dateString = '2026-10-14';
            $dateValueObject = DateValueDummy::fromString($dateString);
            expect($dateValueObject->toDateTimeImmutable())
                ->toEqual(DateTimeImmutable::createFromFormat('Y-m-d|', $dateString));
        });
    });
});
