<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasUuids;

    public $timestamps = true;

    protected $table = 'companies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];

    /**
     * @return string[]
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
