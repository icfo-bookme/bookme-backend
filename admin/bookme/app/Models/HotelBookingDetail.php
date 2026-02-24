<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelBookingDetail extends Model
{
    use HasFactory;

    protected $table = 'hotel_booking_details';
    protected $primaryKey = 'detail_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;


    protected $fillable = [
        'order_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_guests',
        'price_per_night',
        'total_price',
        'special_requests',
    ];

    /**
     * Relationship with BookingOrder
     * Many booking details belong to one booking order
     */
    public function bookingOrder()
    {
        return $this->belongsTo(BookingOrder::class, 'order_id', 'orderno');
    }

    /**
     * Relationship with Room
     * Each booking detail belongs to a specific room
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
