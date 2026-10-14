<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

use DomainException;

class PaymentDate
{
    public static function fromString(string $date): self
    {
        throw new DomainException("{$date} is not a valid date in the YYYY-MM-DD format");
    }

    public function toString(): string
    {
        return '';
    }
}
