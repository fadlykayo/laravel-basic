<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products'; // untuk make sure supaya lebih aman namanya products

    protected $casts = [
        'price' => 'integer', // make sure tipe data nya sebagai integer
        'is_active' => 'boolean'
    ];

    protected $fillable = [ // lawan nya $guarded
        'sku',
        'name',
        'stock',
        'price',
        'description'
    ];
}
