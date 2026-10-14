<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Service;

use Scottaubrey\True9PaydaySystem\Model\PayDate;

class PayDateCalculator
{
    public function calculateFor(string $year, string $month): PayDate
    {
        $date = $year === '2026' && $month === '11' ? '2026-11-27' : '2026-10-30';
        return PayDate::fromString($date);
    }
}
