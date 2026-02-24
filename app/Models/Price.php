<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'price';

    protected $fillable = [
        'unit_id',
        'price',
        'round_trip_price',
        'effectfrom',
        'effective_till',
    ];
    
    public function propertyUnits()
    {
        return $this->belongsTo(Price::class, 'unit_id', 'unit_id');
    }
}
