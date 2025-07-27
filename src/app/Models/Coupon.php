<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Cupom de desconto disponível para pedidos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_subtotal',
        'valid_from',
        'valid_to'
    ];
    protected $casts = [
        'valid_from'   => 'date',
        'valid_to'     => 'date',
        'discount_value' => 'decimal:2',
        'min_subtotal' => 'decimal:2',
    ];
}
