<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFacility extends Model
{
    use HasFactory;

    protected $table = 'property_facilities';
   
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'property_id',
        'facility_type',
        'facilty_name',
        'value',
        'img',
        'icon',
        'isactive',
        'serialno',
    ];

    public $timestamps = true;

    // Define the relationship if there's a foreign key relationship with the property table
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }
    public function icons()
    {
        return $this->belongsTo(Icon::class, 'icon', 'id');
    }
    public function facilityTypes()
    {
        return $this->belongsTo(PropertyFacilityType::class, 'facility_type', 'id');
    }
  
}
