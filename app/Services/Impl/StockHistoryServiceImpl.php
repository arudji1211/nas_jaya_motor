<?php

namespace App\Services\Impl;

use App\Models\StockHistory;
use App\Services\StockHistoryService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class StockHistoryServiceImpl implements StockHistoryService
{
    function create(int $id, int $stock): bool
    {
        $data = new StockHistory([
            'item_id' => $id,
            'stock' => $stock
        ]);
        return $data->query()->save();
    }

    function update(int $item_id, $last_stock, string $tanggal): bool
    {
        $tanggal_skarang = Carbon::parse($tanggal)->format('Y-m-d');
        $tr = StockHistory::query()->whereDate('created_at', $tanggal_skarang)->where('item_id', '=', $item_id)->first();
        if (is_null($tr)) {
            $data = new StockHistory([
                'item_id' => $item_id,
                'stock' => $last_stock
            ]);
            return $data->save();
        } else {
            $tr->stock = $last_stock;
            return $tr->save();
        }
    }

    function getAll(): Collection
    {
        $data = StockHistory::query()->get();
        return $data;
    }

    function getByItemID(int $item_id): Collection
    {
        $data = StockHistory::query()->where('item_id', '=', $item_id)->get();
        return $data;
    }
    function getByTime(string $tanggal): Collection
    {
        $tanggal_skarang = Carbon::parse($tanggal)->format('Y-m-d');
        $tr = StockHistory::query()->whereDate('created_at', $tanggal_skarang)->get();
        return $tr;
    }

    function getByTimeRange(string $start, $stop): Collection
    {
        $tstart = Carbon::parse($start)->startOfDay();
        $tstop = Carbon::parse($stop)->endOfDay();
        $tr = StockHistory::query()->whereBetween('created_at', [$tstart, $tstop])->get();
        return $tr;
    }

    function getByIdItemAndTime(int $id_item, string $time): StockHistory
    {
        $tanggal = Carbon::parse($time)->format('Y-m-d');
        $data = StockHistory::query()->whereDate('created_at', $tanggal)->where('item_id', '=', $id_item)->get();
        return $data;
    }
}
