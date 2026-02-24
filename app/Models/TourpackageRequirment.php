<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourpackageRequirment extends Model
{
    use HasFactory;

    protected $table = 'tourpackage_requirment';

    protected $fillable = [
        'property_id',
        'requirments',
    ];
    
    
    public function property()
{
    return $this->belongsTo(Property::class, 'property_id', 'property_id');
}

}
