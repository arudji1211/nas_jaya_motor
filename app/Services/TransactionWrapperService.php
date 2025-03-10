<?php

namespace App\Services;

use App\Models\TransactionWrapper;

interface TransactionWrapperService
{
    function getAll(): array;
    function getByID(int $id): TransactionWrapper;
    function create(int $id, string $nama_konsumen, $plat, $status): TransactionWrapper;
    function updateStatus(int $id, string $status): bool;
    function delete(int $id): bool;
}
