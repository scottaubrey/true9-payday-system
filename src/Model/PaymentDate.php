<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Model;

use Scottaubrey\True9PaydaySystem\Model\Behaviours\DateValue;

class PaymentDate implements Date
{
    use DateValue;
}
