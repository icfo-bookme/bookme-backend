<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'bed_configuration',
        'max_adults',
        'complementary_child_occupancy',
        'extra_bed_available',
        'max_guests_allowed',
        'room_type',
        'smoking_status',
        'room_characteristics',
        'room_size_sqft',
        'room_view',
        'main_image',
        'name',
        'description',
         'hotel_id',
         'discouont',
         'price',
         'breakfast_status',
    ];

    protected $casts = [
        'extra_bed_available' => 'boolean',
        'room_size_sqft' => 'float',
    ];

    // Relationship with room images
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    public function roomFeatures()
{
    return $this->hasMany(RoomFeature::class);
}

public function roomType()
{
    return $this->belongsTo(RoomType::class, 'room_type');
}

  public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }


}