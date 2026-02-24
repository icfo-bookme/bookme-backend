<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPolicy extends Model
{
    use HasFactory;

    protected $table = 'hotel_policies';
    public $timestamps = false;


    protected $fillable = [
        'name',
        'value',
         'hotel_id',
        'icon_class'
    ];

    
}