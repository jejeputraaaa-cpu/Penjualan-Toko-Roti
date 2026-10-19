<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pesanan',
        'email_pembeli',
        'total',
        'metode_bayar',
        'status',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}