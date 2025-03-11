<?php

namespace App\Services;

use App\Models\TransactionWrapper;
use Illuminate\Database\Eloquent\Collection;

interface TransactionWrapperService
{
    function getAll(): Collection;
    function getByID(int $id): TransactionWrapper;
    function create(string $nama_konsumen, $plat, $status): TransactionWrapper;
    function updateStatus(int $id, string $status): bool;
    function delete(int $id): bool;
}
