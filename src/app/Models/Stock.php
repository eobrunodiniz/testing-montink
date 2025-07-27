<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

/**
 * Estoque de variações de produtos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'variation', 'quantity'];

    /**
     * Produto relacionado a este estoque.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
