<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $guarded = [];

    public static function getBasicDetails($data) : array
    {
        return [
            'name' => $data['name'],
            'code' => $data['code'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'manufacturer' => $data['manufacturer'],
            'product_type' => $data['product_type'],
            'tax' => $data['tax']
        ];
    }
}
