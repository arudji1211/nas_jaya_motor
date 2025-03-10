<?php

namespace App\Services\Impl;

use App\Models\TransactionWrapper;
use App\Services\TransactionWrapperService;
use Exception;

class TransactionWrapperServiceImpl implements TransactionWrapperService
{
    function getAll(): array
    {
        $data = TransactionWrapper::query()->getAll();
        return $data;
    }

    function getByID(int $id): TransactionWrapper
    {
        $data = TransactionWrapper::query()->find($id);
        if (count($data) > 0) {
            return $data;
        } else {
            throw new Exception("Data tidak ditemukan", 404);
        }
    }

    function create(int $id, string $nama_konsumen, $plat, $status): TransactionWrapper
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
        if ($data['id'] != $id) {
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
