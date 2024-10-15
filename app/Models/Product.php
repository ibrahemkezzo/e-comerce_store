<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'description', 'image', 'price', 'discount_price', 'category_id' ,'color' , 'size'];


    public  function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
