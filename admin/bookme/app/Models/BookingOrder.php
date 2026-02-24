<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingOrder extends Model
{
    use HasFactory;

    protected $table = 'bookingorder';
    protected $primaryKey = 'orderno';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'order_date',
        'customerid',
        'customer_name',
        'mobile_no',
        'email',
        'order_status',
        'payment_status',
        'property_id',
        'service_category_id',
        'purchaser',
        'total_paid',
        'total_payable',
        'verified_by'
    ];

    /**
     * Relationship with HotelBookingDetail
     * One booking order can have many booking details
     */
    public function bookingDetails()
    {
        return $this->hasMany(HotelBookingDetail::class, 'order_id', 'orderno');
    }
    
    public function activitieDetails()
    {
        return $this->hasMany(ActivitiesOrderDetail::class, 'order_id', 'orderno');
    }
}
