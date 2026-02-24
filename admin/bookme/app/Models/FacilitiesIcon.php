<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitiesIcon extends Model
{
    use HasFactory;

    protected $table = 'facilities_icons';

    protected $fillable = [
        'icon_class',
        'facility_id',
        'type'
    ];

   public function feature()
{
    return $this->belongsTo(Feature::class, 'facility_id', 'id');
}

}