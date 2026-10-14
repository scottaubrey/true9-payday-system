<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

use DateTimeImmutable;
use DomainException;

class PaymentDate
{
    public static function fromString(string $date): self
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $date);
        if ($date === false) {
            throw new DomainException("{$date} is not a valid date in the YYYY-MM-DD format");
        }
        return new self();
    }

    public function toString(): string
    {
        return '';
    }
}
