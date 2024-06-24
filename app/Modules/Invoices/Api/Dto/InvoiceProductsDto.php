<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Invoice\Domain\ValueObjects\ProductVo;
use Illuminate\Database\Eloquent\Collection;

final class InvoiceProductsDto
{
    private Collection $products;

    private function __construct(Collection $products)
    {
        $this->products = $products;
    }

    public static function fromCollection(Collection $products): self
    {
        return new self($products);
    }

    /**
     * @return array<string|int>
     */
    public function format(): array
    {
        return $this->products->map(function ($item) {
            return ProductVo::create($item)->toArray();
        })->toArray();
    }
}
