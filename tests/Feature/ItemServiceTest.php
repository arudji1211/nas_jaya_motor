<?php

namespace Tests\Feature;

use App\Services\ItemService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private ItemService $itemService;
    public $id_item;

    protected function setUp(): void
    {
        parent::setUp();

        //membuat object item service
        $this->itemService = $this->app->make(ItemService::class);
    }

    public function test_item_service_create()
    {
        //create items
        $response = $this->itemService->create(1, '', 'ban dalam', 100000, 5000, 5);
        $this->id_item = $response->id;
        ///echo $this->id_item;
        self::assertTrue($response->id > 0);
    }

    public function test_increment_func()
    {

        //increase items
        $response = $this->itemService->incrementStock(1, 1, 3);
        self::assertTrue($response);
    }

    public function test_decrement_func()
    {

        //increase items
        $response = $this->itemService->decrementStock(1, 2);
        self::assertTrue($response);
    }

    public function test_delete_func()
    {
        $response = $this->itemService->delete(1, 12);
        echo $this->id_item;
        self::assertTrue($response > 0 ? true : false);
    }
}
