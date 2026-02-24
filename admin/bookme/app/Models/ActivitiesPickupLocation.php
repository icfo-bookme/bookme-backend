<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitiesPickupLocation extends Model
{
    protected $table = 'activities_pickup_location';

    protected $fillable = [
        'destination',
        'property_id',
    ];

    
}
