<?php

declare(strict_types=1);

namespace Tests\Unit\Invoice;

use App\Domain\Invoice\Domain\Models\Company;
use App\Domain\Invoice\Domain\Models\Invoice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mockery;
use Tests\TestCase;

class InvoiceModelTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testInvoiceModelCalculatesTotalAmountCorrectly(): void
    {
        // Create a partial mock of the Invoice model
        $invoiceMock = Mockery::mock(Invoice::class)->makePartial();

        // Create a mock for the products relationship
        $productsMock = Mockery::mock(BelongsToMany::class);

        // Define expectations for the products method
        $invoiceMock->shouldReceive('products')
            ->once()
            ->andReturn($productsMock);

        // Define expectations for the sum method on the products relationship
        $productsMock->shouldReceive('sum')
            ->with('price')
            ->once()
            ->andReturn(300);

        // Test the getTotalAmountAttribute method
        $totalAmount = $invoiceMock->getTotalAmountAttribute();
        $this->assertEquals(300, $totalAmount);
    }

    public function testInvoiceModelReturnsRelatedCompany(): void
    {
        // Create a partial mock of the Invoice model
        $invoiceMock = Mockery::mock(Invoice::class)->makePartial();

        // Create a mock for the company relationship
        $companyRelationMock = Mockery::mock(BelongsTo::class);
        $companyMock = new Company(['name' => 'Mocked Company']);

        // Define expectations for the company method
        $invoiceMock->shouldReceive('company')
            ->once()
            ->andReturn($companyRelationMock);

        // Define expectations for the first method on the company relationship
        $companyRelationMock->shouldReceive('first')
            ->once()
            ->andReturn($companyMock);

        // Test the company relationship
        $company = $invoiceMock->company()->first();
        $this->assertEquals('Mocked Company', $company->name);
    }
}
