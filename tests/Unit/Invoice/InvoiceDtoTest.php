<?php

declare(strict_types=1);

namespace Tests\Unit\Invoice;

use App\Domain\Invoice\Domain\Models\Company;
use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Models\Product;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceDtoTest extends TestCase
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

    public function testCreateInvoiceDtoInstance(): void
    {
        $invoiceDto = InvoiceDto::fromModel($this->invoice);
        $this->assertInstanceOf(InvoiceDto::class, $invoiceDto);
    }

    public function testFormatInvoiceDtoObject(): void
    {
        $invoiceDto = InvoiceDto::fromModel($this->invoice);

        $expectedFormat = [
            'id' => $this->invoice->id,
            'number' => $this->invoice->number,
            'date' => $invoiceDto->date->format(),
            'due_date' => $invoiceDto->dueDate->format(),
            'company' => $invoiceDto->company->format(),
            'billed_company' => $invoiceDto->billedCompany->format(),
            'products' => $invoiceDto->products->format(),
            'total_amount' => $invoiceDto->totalAmount->format(),
            'status' => $invoiceDto->status->value,
        ];

        $this->assertEquals($expectedFormat, $invoiceDto->format());
    }
}
