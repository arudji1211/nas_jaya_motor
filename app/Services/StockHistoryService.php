<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface StockHistoryService
{
    function create(): bool;
    function update(): bool;
    function getAll(): Collection;
    function getByID(): Collection;
    function getByTime(): Collection;
    function getByIdItemAndTime();
}
