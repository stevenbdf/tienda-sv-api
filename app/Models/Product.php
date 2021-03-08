<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'img',
        'description',
        'regular_price',
        'sale_price',
        'stock_qty'
    ];

    public function orders(){
        return $this-> belongsToMany(
            Order::class,
            'order_product',
            'product_id',
            'order_id'
        );
    }

    public function categories(){
        return $this-> belongsToMany(
            category::class,
            'category_product',
            'category_id',
            'product_id'
            
            
        );
    }
}
