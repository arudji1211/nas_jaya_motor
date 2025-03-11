<?php

namespace Tests\Feature;

use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private TransactionService $transaction;

    function setUp(): void
    {
        parent::setUp();
        $this->transaction = $this->app->make(TransactionService::class);
    }

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_transaction_service_createWithTransaction()
    {
        $data_transaksi = [
            [
                'user_id' => 1,
                'item_id' => 1,
                'jenis' => 'pemasukan',
                'nama' => null,
                'transaction_wrapper_id' => 3,
                'cost' => 0,
                'jumlah' => 2
            ],
            [
                'user_id' => 1,
                'item_id' => 2,
                'jenis' => 'pemasukan',
                'nama' => null,
                'transaction_wrapper_id' => 3,
                'cost' => 0,
                'jumlah' => 1
            ],
            [
                'user_id' => 1,
                'item_id' => 0,
                'jenis' => 'pemasukan',
                'nama' => 'pemasangan ban',
                'transaction_wrapper_id' => 3,
                'cost' => 100000,
                'jumlah' => 1
            ]
        ];

        $result = $this->transaction->createWithTransaction($data_transaksi);
        self::assertTrue($result);
    }
}
