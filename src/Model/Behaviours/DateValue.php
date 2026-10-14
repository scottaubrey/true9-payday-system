<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model\Behaviours;

use DateTimeImmutable;
use DomainException;

trait DateValue
{
    final private function __construct(
        private DateTimeImmutable $value,
    ) {}

    public static function fromString(string $date): static
    {
        $value = DateTimeImmutable::createFromFormat('Y-m-d|', $date);
        if ($value === false || \DateTime::getLastErrors() !== false) {
            throw new DomainException("{$date} is not a valid date in the YYYY-MM-DD format");
        }
        return new static($value);
    }

    public function toString(): string
    {
        return $this->value->format('Y-m-d');
    }

    public function toDateTimeImmutable(): DateTimeImmutable
    {
        return $this->value;
    }
}
