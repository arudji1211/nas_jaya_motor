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
                'transaction_wrapper_id' => 1,
                'cost' => 0,
                'jumlah' => 2
            ],
            [
                'user_id' => 1,
                'item_id' => 2,
                'jenis' => 'pemasukan',
                'nama' => null,
                'transaction_wrapper_id' => 1,
                'cost' => 0,
                'jumlah' => 1
            ],
            [
                'user_id' => 1,
                'item_id' => null,
                'jenis' => 'pemasukan',
                'nama' => 'pemasangan ban',
                'transaction_wrapper_id' => 1,
                'cost' => 100000,
                'jumlah' => 1
            ]
        ];

        $result = $this->transaction->createWithTransaction($data_transaksi);
        self::assertTrue($result);
    }

    public function test_transaction_service_getbydate()
    {
        $data = $this->transaction->getByDateRange('2025-03-13', '2025-03-14');
        //print_r($data);
        foreach ($data as $d) {
            if (!is_null($d->item)) {
                echo '' . $d->item['nama'] . ' sebanyak ' . $d->jumlah . ' = Rp.' . $d->cost_total . "\r\n";
            } else {
                echo '' . $d->nama . ' sebanyak ' . $d->jumlah . ' = Rp.' . $d->cost_total . "\r\n";
            }
        }
    }
}
