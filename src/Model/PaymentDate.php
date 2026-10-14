<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

class PaymentDate
{
    public static function fromString(string $date): self
    {
        return new self();
    }

    public function toString(): string
    {
        return '';
    }
}
