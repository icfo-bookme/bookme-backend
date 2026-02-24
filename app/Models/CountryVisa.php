<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryVisa extends Model
{
    use HasFactory;
    protected $table = 'country_visa';
    protected $fillable = [
        'name',
        'popularityScore',
        'description',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
   public function properties()
    {
        return $this->hasMany(Property::class, 'destination_id', 'id')
                    ->where('category_id', 4);
    }
}