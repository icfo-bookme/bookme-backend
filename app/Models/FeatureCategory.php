<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureCategory extends Model
{
    use HasFactory;
   public $timestamps = false;

protected $table = 'facility_categories';

    protected $fillable = ['name', 'isactive', 'type'];

    protected $casts = [
        'isactive' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive', true);
    }
    
    
    public function feature()
    {
        return $this->hasMany(Feature::class, 'category_id');
    }
}