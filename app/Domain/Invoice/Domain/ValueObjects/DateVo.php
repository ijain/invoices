<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\ValueObjects;

use Carbon\Carbon;
use InvalidArgumentException;

final readonly class DateVo
{
    private Carbon $date;

    private function __construct(?string $date)
    {
        if (!$this->isValidDate($date)) {
            throw new InvalidArgumentException('Invalid date');
        }

        $this->date = Carbon::parse($date);
    }

    public static function create(?string $dateValue): self
    {
        return new self($dateValue);
    }

    public function format(): string
    {
        return $this->date->toDateString();
    }

    private function isValidDate(string $date): bool
    {
        return (bool) strtotime($date);
    }
}
