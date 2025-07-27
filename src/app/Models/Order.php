<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Coupon;

/**
 * Representa um pedido realizado na aplicação.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class Order extends Model
{
    use HasFactory;

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

    /**
     * Cupom aplicado ao pedido, se houver.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
