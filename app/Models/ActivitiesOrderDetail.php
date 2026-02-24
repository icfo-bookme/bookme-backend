<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivitiesOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'activities_order_details'; 

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'order_id',
        'package_id',
        'package_name',
        'base_price',
        'discount_percent',
        'discount_amount',
        'final_price',
        'activity_date',
        'activity_time',
        'total_guests',
        'pickup_location',
        'special_requests',
    ];

    protected $casts = [
        'base_price' => 'float',
        'discount_percent' => 'float',
        'discount_amount' => 'float',
        'final_price' => 'float',
        'activity_date' => 'date',
        'activity_time' => 'datetime:H:i:s',
        'total_guests' => 'integer',
    ];

    /**
     * Relationship to BookingOrder (assuming model is BookingOrder.php)
     */
    public function bookingOrder()
    {
        return $this->belongsTo(BookingOrder::class, 'order_id', 'orderno');
    }
}
