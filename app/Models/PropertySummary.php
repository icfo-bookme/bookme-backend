<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySummary extends Model
{
    use HasFactory;
    protected $table = 'property_summary';
    protected $fillable = ['property_id','name', 'value', 'icon', 'display'];

    // Define the relationship to the Property model (if exists)
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    public function addRooms()
    {
        return $this->hasMany(PropertyUnit::class, 'property_id', 'property_id');
    }

    public function icons()
    {
        return $this->belongsTo(Icon::class, 'icon', 'id');
    }
    
   public function summaryType()
{
    return $this->belongsTo(PropertySummaryType::class, 'name', 'id');
}

}

