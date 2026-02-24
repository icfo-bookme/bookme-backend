<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartSession extends Model
{
    use HasFactory;

    protected $table = 'cart_session';

    protected $fillable = [
        'item_id',
        'pickup_location',
        'total_guest',
        'date',
        'time',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
    ];
}
