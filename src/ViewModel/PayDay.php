<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\ViewModel;

use Scottaubrey\True9PaydaySystem\Model\PayDate;
use Scottaubrey\True9PaydaySystem\Model\PaymentDate;

class PayDay
{
    public function __construct(
        public readonly PayDate $payDate,
        public readonly PaymentDate $paymentDate,
    ) {}

    public static function fromJson(string $json): self
    {
        /** @var array{payDate: string, paymentDate: string} */
        $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);

        return new self(PayDate::fromString($data['payDate']), PaymentDate::fromString($data['paymentDate']));
    }

    public function toJson(): string
    {
        return json_encode([
            'payDate' => $this->payDate->toString(),
            'paymentDate' => $this->paymentDate->toString(),
        ], flags: JSON_THROW_ON_ERROR);
    }
}
