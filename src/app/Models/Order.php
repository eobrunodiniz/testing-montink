<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // ← importe

class Order extends Model
{
    use HasFactory;                                      // ← use aqui

    protected $fillable = [
        'items',
        'subtotal',
        'shipping',
        'discount',
        'total',
        'coupon_id',
        'cep',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'status',
        'email'
    ];

    protected $casts = [
        'items'     => 'array',
        'subtotal'  => 'decimal:2',
        'shipping'  => 'decimal:2',
        'discount'  => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
