<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discount'; // Table name
    protected $fillable = [
        'unit_id',
        'discount_percent',
        'discount_amount',
        'effectfrom',
        'effective_till',
    ];
    
    // Relationship with PropertyUnit model (if applicable)
    public function unit()
    {
        return $this->belongsTo(PropertyUnit::class, 'unit_id', 'unit_id');
    }
}
