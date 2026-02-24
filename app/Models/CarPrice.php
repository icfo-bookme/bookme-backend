<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPrice extends Model
{
    use HasFactory;

    protected $table = 'car_price';

    protected $fillable = [
        'property_id',
        'price_upto_4_hours',
        'price_upto_6_hours',
        'kilometer_price',
    ];
}

