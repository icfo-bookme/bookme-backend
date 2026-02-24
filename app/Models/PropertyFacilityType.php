<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFacilityType extends Model
{
    use HasFactory;

   
    protected $table = 'property_facility_type'; 
    public $timestamps = true; 
    // Define the fillable properties to allow mass assignment
    protected $fillable = [
        'property_category',
        'facility_typename',
        'img',
        'isactive',
    ];

    
    protected $casts = [
        'isactive' => 'boolean',
    ];

    public function facilities()
{
    
    return $this->hasMany(PropertyFacility::class, 'facility_type', 'id');
}
}
