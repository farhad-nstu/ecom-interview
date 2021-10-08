<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivered extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_quantity', 'order_date', 'shipping_address', 'shipping_cost', 'net_price', 'user_id', 'product_price'
    ];
}
