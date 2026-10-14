<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

interface Date
{
    public static function fromString(string $date): static;

    public function toString(): string;
}
