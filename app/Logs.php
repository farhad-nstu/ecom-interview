<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_quantity', 'order_date', 'shipping_address', 'shipping_cost', 'net_price', 'order_status', 'edit_date', 'user_id', 'product_price'
    ];
}
