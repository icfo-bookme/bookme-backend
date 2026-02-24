<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_model';  // singular table name

    protected $fillable = [
        'brand_id',
        'model_name',
        'image',
        'status',
    ];

    // Relationship to CarBrand
    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }
    
    public function BrandProperty()
{
    return $this->hasOne(BrandProperty::class, 'model_id', 'id');
}

}
