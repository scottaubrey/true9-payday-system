<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\ViewModel;

use Scottaubrey\True9PaydaySystem\Model\PayDate;

class PayDay
{
    public function __construct(
        public readonly ?PayDate $payDate = null,
    ) {}

    public static function fromJson(string $_json): self
    {
        return new self();
    }
}
