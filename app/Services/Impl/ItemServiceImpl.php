<?php

namespace App\Services\Impl;

use App\Services\ItemService;

class ItemServiceImpl implements ItemService
{
    function create(int $user_id, string $bar_code, string $nama, int $harga, int $markup, int $stock) {}

    function update(int $user_id, int $id, array $update_items) {}

    function incrementStock(int $user_id, int $id, $count) {}

    function decrementStock(int $id, $count) {}

    function delete(int $user_id, $id) {}
}
