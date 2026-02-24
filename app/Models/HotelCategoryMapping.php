<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelCategoryMapping extends Model
{
    protected $table = 'hotel_category_mappings';

    protected $fillable = [
        'hotel_id',
        'category_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function category()
    {
        return $this->belongsTo(HotelCategory::class, 'category_id');
    }
}
