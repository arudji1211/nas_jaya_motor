<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'bar_code',
        'nama',
        'harga',
        'markup',
        'stock',
    ];

    function Transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'item_id', 'id');
    }

    function StockHistory(): BelongsTo
    {
        return $this->belongsTo(StockHistory::class, 'item_id', 'id');
    }
}
