<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\ValueObjects;

final readonly class MoneyVo
{
    private const DEFAULT_CURRENCY = 'USD';

    private int $amount;
    private string $currency;

    private function __construct(int $amount)
    {
        $this->amount = $amount;
        $this->currency = self::DEFAULT_CURRENCY;
    }

    public static function create(int $amount): self
    {
        return new self($amount);
    }

    public function format(): string
    {
        return $this->amount . ' ' . $this->currency;
    }
}
