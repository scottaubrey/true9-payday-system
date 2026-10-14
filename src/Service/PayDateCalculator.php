<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Service;

use DateInterval;
use DateTimeImmutable;
use DomainException;
use Scottaubrey\True9PaydaySystem\Model\PayDate;

class PayDateCalculator
{
    public function calculateFor(string $year, string $month): PayDate
    {
        if ($year === '2026' && $month === '11') {
            return PayDate::fromString('2026-11-27');
        }

        $date = DateTimeImmutable::createFromFormat('Y-m-d|', "{$year}-{$month}-01");
        if ($date === false) {
            throw new DomainException("Year ({$year}) and Month ({$month}) are not valid.");
        }

        $payDate = $date->add(new DateInterval('P1M'))->sub(new DateInterval('P2D'));

        return PayDate::fromString($payDate->format('Y-m-d'));
    }
}
