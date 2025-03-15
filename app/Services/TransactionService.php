<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

interface TransactionService
{
    function createWithTransaction(array $data): bool;
    function create($user_id, $item_id, $jenis, $nama, $transaksi_wrapper_id, $cost, $jumlah): Transaction;
    function getAll(): Collection;
    function getByID($id): Transaction;
    function getByDateRange(string $start, $end): Collection;
    function updateAmount($id, $jumlah): bool;
    function delete($id): bool;
}
