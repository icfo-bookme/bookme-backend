<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightRoute extends Model
{
    protected $table = 'flight_routes';

    protected $fillable = [
        'origin_city',
        'destination_city',
        'origin_airport_name',
        'destination_airport_name',
        'number_of_stops',
        'flight_duration',
        'airline_icon_url',
        'base_price',
        'discount_percent',
        'flight_type',
        'popularity_score'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];
}
