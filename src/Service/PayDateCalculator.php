<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Service;

use DateInterval;
use DateTimeImmutable;
use DomainException;
use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\Model\PaymentDate;
use Yasumi\ProviderInterface;
use Yasumi\Yasumi;

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

    private function isPublicHoliday(DateTimeImmutable $date): bool
    {
        $publicHolidayCalculator = \Yasumi\Yasumi::create(
            'UnitedKingdom\England',
            locale: 'en_GB',
            year: intval($date->format('Y')),
        );

        return $publicHolidayCalculator->isHoliday($date);
    }

    public function calculateFor(string $year, string $month): PayDate
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d|', "{$year}-{$month}-01");
        if ($date === false || DateTimeImmutable::getLastErrors() !== false) {
            throw new DomainException("Year ({$year}) and Month ({$month}) are not valid.");
        }

        $potentialPayDate = $date->add(new DateInterval('P1M'))->sub(new DateInterval('P2D'));

        do {
            if ($this->isWeekend($potentialPayDate)) {
                $potentialPayDate = $this->moveBackToFriday($potentialPayDate);
                continue;
            }

            if ($this->isPublicHoliday($potentialPayDate)) {
                $potentialPayDate = $potentialPayDate->sub(new DateInterval('P1D'));
                continue;
            }
            $payDate = $potentialPayDate;
            break;
        } while (true);

        return PayDate::fromString($payDate->format('Y-m-d'));
    }

    private function getPublicHolidayCalculatorFor(int $year): ProviderInterface
    {
        return Yasumi::create('UnitedKingdom\England', locale: 'en_GB', year: $year);
    }

    public function calculatePaymentDateFor(PayDate $payDate): PaymentDate
    {
        $publicHolidayCalculator = $this->getPublicHolidayCalculatorFor(intval(
            $payDate->toDateTimeImmutable()->format('Y'),
        ));
        $potentialPaymentDate = $payDate->toDateTimeImmutable();
        $workingDays = 0;
        do {
            $potentialPaymentDate = $potentialPaymentDate->sub(new DateInterval('P1D'));
            if ($publicHolidayCalculator->isWorkingDay($potentialPaymentDate)) {
                $workingDays++;
            }
        } while ($workingDays < 4);
        return PaymentDate::fromString($potentialPaymentDate->format('Y-m-d'));
    }
}
