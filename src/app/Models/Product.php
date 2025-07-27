<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Stock;

/**
 * Modelo de produto da aplicação.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'variations'];

    protected $casts = [
        'variations' => 'array',
    ];

    /**
     * Relação com os estoques do produto.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
