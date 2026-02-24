<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFeature extends Model
{
    use HasFactory;
   public $timestamps = false;
    protected $table = 'hotel_features';

    protected $fillable = [
        'hotel_id',
        'feature_id',
        'isfeature',
        'isfeature_summary',
    ];

    // Relationships
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
      public function icon()
    {
        return $this->belongsTo(FacilitiesIcon::class,'facility_id');
    }
}