<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'star_rating',
        'phone_number',
        'email',
        'website_url',
        'country_id',
        'city',
        'street_address',
        'languages_spoken',
        'location_on_map',
        'main_photo',
        'destination_id',
        'room_type',
        'extra_discount_msg',
        'number_of_rooms',
        'Number_of_Floors',
        'Year_of_construction',
        'near_by',
        'is_active',
        'vat',
        'label',
        'service_charge',
        'added_by'
    ];

    // Relationships
    public function hotelFeatures()
{
    return $this->hasMany(HotelFeature::class, 'hotel_id');
}


    public function category()
    {
        return $this->belongsTo(HotelCategory::class, 'category_id');
    }

    public function country()
    {
        return $this->belongsTo(HotelCountry::class, 'country_id');
    }

    public function photos()
    {
        return $this->hasMany(HotelPhoto::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    
   public function user()
   
    {
    return $this->belongsTo(User::class, 'added_by', 'id');
    }

    
    
    public function facilitiesFeatures()
{
    return $this->hasMany(HotelFeature::class)->where('isfeature', 1);
}
    
     public function feature()
    {
        return $this->hasMany(HotelFeature::class, 'hotel_id');
    }
public function categories()
{
    return $this->belongsToMany(
        HotelCategory::class,
        'hotel_category_mappings',
        'hotel_id', // This is the foreign key on the pivot table pointing to Hotel
        'category_id' // This is the foreign key on the pivot table pointing to HotelCategory
    );
}

    
}
