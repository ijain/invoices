<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\ValueObjects;

use App\Domain\Invoice\Domain\Models\Product;

final readonly class ProductVo
{
    private string $name;
    private int $quantity;
    private int $price;
    private int $totalPrice;

    private function __construct(Product $product)
    {
        $this->name = $product->name;
        $this->quantity = $product->pivot->quantity;
        $this->price = $product->price;
        $this->totalPrice = $this->quantity * $this->price;
    }

    public static function create(Product $product): self
    {
        return new self($product);
    }

    /**
     * @return array<string|integer>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'totalPrice' => $this->totalPrice,
        ];
    }
}
