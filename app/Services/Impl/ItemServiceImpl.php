<?php

namespace App\Services\Impl;

use App\Models\Item;
use App\Models\User;
use App\Services\UserService;
use App\Services\ItemService;
use App\Services\StockHistoryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ItemServiceImpl implements ItemService
{

    protected StockHistoryService $stockHistory;
    private UserService $userService;

    public function __construct(UserService $userServ, StockHistoryService $stockhist)
    {
        $this->userService = $userServ;
        $this->stockHistory = $stockhist;
    }

    function getAll(): Collection
    {
        $data = Item::query()->get();
        return $data;
    }

    function getByID(int $id): Item
    {
        $data = Item::query()->find($id);
        if ($data->id == null) {
            throw new Exception("Barang tidak di temukan", 404);
        }
        return $data;
    }

    function getByBarcode(string $barcode): Item
    {
        $data = Item::query()->find($barcode, 'bar_code');
        if ($data->id == null) {
            throw new Exception("Barang tidak di temukan", 404);
        }
        return $data;
    }

    function create(int $user_id, string $bar_code, string $nama, int $harga, int $markup, int $stock): Item
    {
        //user cek

        $user = $this->userService->getUser($user_id);
        if ($user['role'] != 'admin') {
            //return false;
            throw new Exception("Anda tidak memiliki akses", 403);
        }

        //create item
        $item = new Item([
            'nama' => $nama,
            'harga' => $harga,
            'markup' => $markup,
            'stock' => $stock
        ]);
        $item->save();
        return $item;
    }

    function update(int $user_id, int $id, array $update_items): bool
    {
        return false;
    }

    function incrementStock(int $user_id, $id, $count): bool
    {
        $user = $this->userService->getUser($user_id);
        if ($user['role'] != 'admin') {
            //return false;
            throw new Exception("Anda tidak memiliki akses", 403);
        }

        $increase = Item::query()->where('id', '=', $id)->increment('stock', $count);
        if ($increase == 1) {
            $data = Item::query()->find($id);
            $now = Carbon::now();
            $this->stockHistory->update($id, $data->stock, $now);
            return true;
        };
        return false;
    }

    function decrementStock(int $id, $count): bool
    {
        $increase = Item::query()->where('id', '=', $id)->decrement('stock', $count);
        if ($increase == 1) {
            $data = Item::query()->find($id);
            $now = Carbon::now();
            $this->stockHistory->update($id, $data->stock, $now);
            return true;
        };
        return false;
    }

    function delete(int $user_id, $id): bool
    {
        $user = $this->userService->getUser($user_id);
        if ($user['role'] != 'admin') {
            //return false;
            throw new Exception("Anda tidak memiliki akses", 403);
        }


        $item = Item::query()->find($id);
        if (!$item) {
            throw new Exception("Error Processing Request", 404);
        }
        return $item->delete();
    }
}
