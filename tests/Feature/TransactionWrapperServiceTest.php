<?php

namespace Tests\Feature;

use App\Models\TransactionWrapper;
use App\Services\TransactionWrapperService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionWrapperServiceTest extends TestCase
{
    private TransactionWrapperService $transactionWrapper;

    function setUp(): void
    {
        parent::setUp();
        $this->transactionWrapper = $this->app->make(TransactionWrapperService::class);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_transaction_wrapper_create()
    {
        //create Transaction Wrapper
        $data = $this->transactionWrapper->create("Arudji Hermatyar", "DD 1234 SZ", "Belum Lunas");
        self::assertTrue($data->id > 0);
    }

    public function test_transaction_wrapper_getAll()
    {
        $data = $this->transactionWrapper->getAll();
        $expected = [
            'id' => 1,
            'nama_konsumen' => 'Arudji Hermatyar',
            'plat' => 'DD 1234 SZ',
            'status' => "Lunas"
        ];
        $response = [];
        foreach ($data as $d) {
            $response['id'] = $d->id;
            $response['nama_konsumen'] = $d->nama_konsumen;
            $response['plat'] = $d->plat;
            $response['status'] = $d->status;
        }

        self::assertTrue($expected['nama_konsumen'] == $response['nama_konsumen']);
    }

    public function test_transaction_wrapper_getByID()
    {
        $data = $this->transactionWrapper->getByID(2);
        self::assertTrue($data->nama_konsumen == 'Arudji Hermatyar');
    }

    public function test_transaction_wrapper_updateStatus()
    {
        $data = $this->transactionWrapper->updateStatus(1, "Lunas");
        self::assertTrue($data);
    }

    public function test_transaction_wrapper_delete()
    {
        $data = $this->transactionWrapper->delete(2);
        self::assertTrue($data);
    }
}
