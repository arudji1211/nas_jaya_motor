<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

interface ItemService
{
    function getByID(int $id): Item;
    function getByBarcode(string $bar_code): Item;
    function getAll(): Collection;
    function create(int $user_id, string $bar_code, string $nama, int $harga, int $markup, int $stock): Item;
    function update(int $user_id, int $id, array $update_items): bool;
    function incrementStock(int $user_id, $id, $count): bool;
    function decrementStock(int $user_id, $id, $count): bool;
    function delete(int $user_id, $id): bool;
}
