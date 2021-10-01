<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'picture', 'quantity'
    ];

    public static $sortable = ['id' => 'id', 'name' => 'name'];
}
