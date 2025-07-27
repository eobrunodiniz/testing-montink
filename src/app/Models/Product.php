<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // ← importe

class Product extends Model
{
    use HasFactory;                                      // ← use aqui

    protected $fillable = ['name', 'price', 'variations'];

    protected $casts = [
        'variations' => 'array',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
