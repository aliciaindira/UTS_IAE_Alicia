<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'buyer_id',
        'product_id',
        'name',
        'phone',
        'product_name',
        'size',
        'quantity',
        'total_price',
        'order_date'
    ];
}
