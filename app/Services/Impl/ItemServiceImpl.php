<?php

namespace App\Services\Impl;

use App\Models\Item;
use App\Models\User;
use App\Services\UserService;
use App\Services\ItemService;
use Exception;
use Illuminate\Support\Arr;

class ItemServiceImpl implements ItemService
{

    private UserService $userService;

    public function __construct(UserService $userServ)
    {
        $this->userService = $userServ;
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
            return true;
        };
        return false;
    }

    function decrementStock(int $id, $count): bool
    {
        $increase = Item::query()->where('id', '=', $id)->decrement('stock', $count);
        if ($increase == 1) {
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
