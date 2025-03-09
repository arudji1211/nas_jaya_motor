<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
