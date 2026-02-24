<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelCountry extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = ['name', 'img'];

    // Relationship: One country has many hotels
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'country_id');
    }
}
