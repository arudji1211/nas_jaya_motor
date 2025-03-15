<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'item_id',
        'jenis',
        'nama',
        'transaction_wrapper_id',
        'cost',
        'harga',
        'jumlah',
        'cost_total'
    ];

    function Item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    function User(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function TransactionWrappers(): BelongsTo
    {
        return $this->belongsTo(TransactionWrapper::class, 'transaction_wrapper_id', 'id');
    }
}
