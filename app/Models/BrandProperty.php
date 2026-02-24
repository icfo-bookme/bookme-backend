<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandProperty extends Model
{
    use HasFactory;

    protected $table = 'brand_property';

    protected $fillable = [
        'property_id',
        'model_id',
        'brand_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class); 
    }
}
