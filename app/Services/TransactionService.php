<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TransactionService
{
    function createWithTransaction(array $data): bool;
    function create($user_id, $item_id, $jenis, $nama, $transaksi_wrapper_id, $cost, $jumlah): Transaction;
    function getAll(): Collection;
    function getByWrapperID($id): Collection;
    function getByID($id): Transaction;
    function getByDateRangeAndJenis(string $start, $end, $jenis): Collection;
    function updateAmount($id, $id_user, $action): bool;
    function delete($id): bool;
}
