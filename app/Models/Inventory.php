<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'category',
        'total_stock',
        'available_stock',
        'price',
        'description',
        'image',
    ];
}
