<?php

namespace App\Services;

use App\Models\Item;

interface ItemService
{
    function create(int $user_id, string $bar_code, string $nama, int $harga, int $markup, int $stock): Item;
    function update(int $user_id, int $id, array $update_items): bool;
    function incrementStock(int $user_id, $id, $count): bool;
    function decrementStock(int $id, $count): bool;
    function delete(int $user_id, $id): bool;
}
