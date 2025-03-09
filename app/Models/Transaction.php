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
        'barang_id',
        'jenis',
        'nama',
        'transaksi_wrapper_id',
        'cost',
        'jumlah',
        'cost_total'
    ];
}
