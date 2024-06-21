<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasUuids;

    public $timestamps = true;

    protected $table = 'products';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    /**
     * @return string[]
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product_lines')
            ->withTimestamps()
            ->withPivot('quantity');
    }
}
