<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'price', // price burada ürüne ait fiyatı tutacak
    ];

    // 'user' ilişkisini tanımlıyoruz
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 'product' ilişkisini tanımlıyoruz
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}



