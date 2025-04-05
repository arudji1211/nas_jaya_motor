<?php

namespace App\Services\Impl;

use App\Models\TransactionWrapper;
use App\Services\TransactionWrapperService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TransactionWrapperServiceImpl implements TransactionWrapperService
{
    function getAll(): Collection
    {
        $data = TransactionWrapper::orderBy('created_at', 'desc')->get();
        return $data;
    }

    function getByID(int $id): TransactionWrapper
    {
        $data = TransactionWrapper::query()->with('transactions.item')->find($id);
        if ($data->id != null) {
            return $data;
        } else {
            throw new Exception("Data tidak ditemukan", 404);
        }
    }

    function create(string $nama_konsumen, $plat, $status): TransactionWrapper
    {
        $data = new TransactionWrapper(
            [
                'nama_konsumen' => $nama_konsumen,
                'plat' => $plat,
                'status' => $status
            ]
        );

        $data->save();
        return $data;
    }

    function updateStatus(int $id, string $status): bool
    {
        $data = $this->getByID($id);
        if ($data['id'] != null) {
            $data['status'] = $status;
            return $data->save();
        } else {
            throw new Exception("gagal update data", 404);
        }
    }

    function delete(int $id): bool
    {
        if (TransactionWrapper::destroy($id) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
