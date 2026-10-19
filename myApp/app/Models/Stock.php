<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stok';

    protected $fillable = [
        'product_id',
        'jumlah',
        'satuan',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}