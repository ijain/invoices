<?php

declare(strict_types=1);

namespace Tests\Unit\Invoice;

use App\Domain\Enums\StatusEnum;
use Ramsey\Uuid\Uuid;

class DataProvider
{
    /**
     * @return array<string|integer>
     */
    public static function dataProducts(): array
    {
        $datetime = date("Y-m-d H:i:s");
        return [
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'pen',
                'price' => 50,
                'currency' => 'usd',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'pencil',
                'price' => 309,
                'currency' => 'usd',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'razer',
                'price' => 27,
                'currency' => 'usd',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'pencil',
                'price' => 30,
                'currency' => 'usd',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'razer',
                'price' => 12,
                'currency' => 'usd',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
        ];
    }

    /**
     * @return array<string>
     */
    public static function dataCompany(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Reichert-Blanda',
            'street' => '116 Jany Dam Apt. 827',
            'city' => 'Selenamouth',
            'zip' => '83983-9996',
            'phone' => '+1-301-830-9732',
            'email' => 'monica.schuppe@example.com',
        ];
    }

    /**
     * @return array<string>
     */
    public static function dataInvoice(string $companyId): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'number' => '4cfc1fac-9186-389a-a9bf-5553570e25f6',
            'date' => '1992-03-29',
            'due_date' => '2006-04-13',
            'company_id' => $companyId,
            'status' => StatusEnum::DRAFT,
        ];
    }
}
