<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'product_quantity', 'order_date', 'shipping_address', 'shipping_cost', 'net_price', 'order_status', 'product_price'
    ];

    public static $sortable = ['id' => 'id', 'name' => 'product_id'];
}
