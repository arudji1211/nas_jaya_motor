<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionWrapper extends Model
{
    use HasFactory;
    protected $table = 'transaction_wrappers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_konsumen',
        'plat',
        'status'
    ];


    function Transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_wrapper_id', 'id');
    }
}
