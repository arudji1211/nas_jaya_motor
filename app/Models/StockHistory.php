<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    protected $table = 'stock_histories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'barang_id'
    ];
}
