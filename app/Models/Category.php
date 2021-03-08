<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'img'
    ];
    public function products(){
        return $this->belongsToMany(
            product::class,
            'category_product',
            'product_id',
            'category_id'
        );
    }
}
