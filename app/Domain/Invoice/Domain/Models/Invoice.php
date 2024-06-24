<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Models;

use App\Domain\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasUuids;

    public $timestamps = true;

    protected $table = 'invoices';

    /**
     * @var string[]
     */
    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'status',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    protected $appends = ['total_amount'];

    /**
     * @return string[]
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getTotalAmountAttribute(): int
    {
        return (int)$this->products()->sum('price');
    }
}
