<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
