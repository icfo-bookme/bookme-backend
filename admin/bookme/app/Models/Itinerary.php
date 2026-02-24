<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
     protected $table = 'itinerary';
    protected $fillable = [
        'dayno',
        'property_id',
        'time',
        'name',
        'value',
        'location',
        'duration',
        'image',
    ];
}
