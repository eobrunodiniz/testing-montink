<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // ← importe

class Stock extends Model
{
    use HasFactory;                                      // ← e aqui

    protected $fillable = ['product_id', 'variation', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
