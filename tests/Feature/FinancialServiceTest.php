<?php

namespace Tests\Feature;

use App\Services\FinancialService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinancialServiceTest extends TestCase
{

    private FinancialService $financial;

    protected function setUp(): void
    {
        parent::setUp();
        $this->financial = $this->app->make(FinancialService::class);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_financial_service_pemasukan()
    {
        $data = $this->financial->Pemasukan('2025-03-01', '2025-03-28');
        var_dump($data);
        self::assertTrue(true);
    }

    public function test_financial_service_laba()
    {
        $data = $this->financial->LabaBersih('2025-03-01', '2025-03-28');
        var_dump($data);
        self::assertTrue(true);
    }
}
