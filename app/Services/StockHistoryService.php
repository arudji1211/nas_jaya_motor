<?php

namespace App\Services;

use App\Models\StockHistory;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface StockHistoryService
{
    function create(int $id, int $stock): bool;
    function update(int $item_id, $last_stock, string $tanggal): bool;
    function getAll(): Collection;
    function getByItemID(int $id): Collection;
    function getByTime(string $tanggal_saat_ini): Collection;
    function getByIdItemAndTime(int $id_item, string $time): StockHistory;
}
