<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Service;

use DateInterval;
use DateTimeImmutable;
use DomainException;
use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\Model\PaymentDate;

class PayDateCalculator
{
    private function isWeekend(DateTimeImmutable $date): bool
    {
        return $date->format('N') > 5;
    }

    private function moveBackToFriday(DateTimeImmutable $date): DateTimeImmutable
    {
        $numberOfDays = intval($date->format('N')) - 5;
        return $date->sub(new DateInterval("P{$numberOfDays}D"));
    }

    public function calculateFor(string $year, string $month): PayDate
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d|', "{$year}-{$month}-01");
        if ($date === false) {
            throw new DomainException("Year ({$year}) and Month ({$month}) are not valid.");
        }

        $potentialPayDate = $date->add(new DateInterval('P1M'))->sub(new DateInterval('P2D'));

        $payDate = $this->isWeekend($potentialPayDate) ? $this->moveBackToFriday($potentialPayDate) : $potentialPayDate;

        return PayDate::fromString($payDate->format('Y-m-d'));
    }

    private function isFriday(DateTimeImmutable $date): bool
    {
        return $date->format('N') === '5';
    }

    public function calculatePaymentDateFor(PayDate $payDate): PaymentDate
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d|', $payDate->toString());
        if ($date === false) {
            throw new DomainException('PayDate is not valid.');
        }

        $intervalIncludingPotentialWeekends = $this->isFriday($date) ? 'P4D' : 'P6D';
        return PaymentDate::fromString($date->sub(new DateInterval($intervalIncludingPotentialWeekends))->format(
            'Y-m-d',
        ));
    }
}
