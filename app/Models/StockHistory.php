<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StockHistory extends Model
{
    use HasFactory;
    protected $table = 'stock_histories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'item_id',
        'stock'
    ];

    function Item(): HasOne
    {
        return $this->hasOne(Item::class, 'item_id', 'id');
    }
}
