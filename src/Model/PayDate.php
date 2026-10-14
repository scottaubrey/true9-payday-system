<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

class PayDate
{
    public static function fromString(string $_date): self
    {
        return new self();
    }
}
