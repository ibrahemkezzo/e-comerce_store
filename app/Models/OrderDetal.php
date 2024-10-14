<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetal extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'order_id', 'product_color_size_id', 'price', 'quantity','discount'];
}
