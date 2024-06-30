<?php

declare(strict_types=1);

namespace Tests\Unit\Invoice;

use App\Domain\Invoice\Domain\Models\Company;
use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Models\Product;
use App\Modules\Invoices\Api\Dto\InvoiceProductsDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceProductsDtoTest extends TestCase
{
    use RefreshDatabase;

    protected $company;
    protected $invoice;
    protected $productList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::create(DataProvider::dataCompany());
        $this->assertDatabaseCount('companies', 1);

        $this->invoice = Invoice::create(DataProvider::dataInvoice($this->company->id));
        $this->assertDatabaseCount('invoices', 1);

        Product::insert(DataProvider::dataProducts());
        $this->assertDatabaseCount('products', 5);

        $quantity = [10,3,28,15,19];
        foreach (Product::all() as $key => $product) {
            $this->invoice->products()->attach(
                $product->id,
                ['id' => Uuid::uuid4()->toString(), 'quantity' => $quantity[$key]]
            );
        }
    }

    public function testCreateProductDtoInstance(): void
    {
        $productDto = InvoiceProductsDto::fromCollection($this->invoice->products);
        $this->assertInstanceOf(InvoiceProductsDto::class, $productDto);
    }

    public function testFormatProductDtoObject(): void
    {
        $productDto = InvoiceProductsDto::fromCollection($this->invoice->products);

        $expectedFormat = [
            ['name' => 'pen', 'quantity' => 10, 'price' => 50, 'totalPrice' => 500],
            ['name' => 'pencil', 'quantity' => 3, 'price' => 309, 'totalPrice' => 927],
            ['name' => 'razer', 'quantity' => 28, 'price' => 27, 'totalPrice' => 756],
            ['name' => 'pencil', 'quantity' => 15, 'price' => 30, 'totalPrice' => 450],
            ['name' => 'razer', 'quantity' => 19, 'price' => 12, 'totalPrice' => 228],
        ];

        $this->assertEquals($expectedFormat, $productDto->format());
    }
}
