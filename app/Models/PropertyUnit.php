<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    use HasFactory;

    // Define the table name (optional if it matches the model name in snake_case)
    protected $table = 'property_unit';

    // Define the primary key (optional if it's `id`)
    protected $primaryKey = 'unit_id';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'property_id',
        'unit_category',
        'unit_no',
        'unit_name',
        'unit_type',
        'person_allowed',
        'additionalbed',
        'description',
        'mainimg',
        'isactive',
        'Max_Stay',
        'Validity',
        'fee_type',
    ];

    public function propertySummaries()
    {
        return $this->belongsTo(PropertySummary::class, 'unit_no', 'unit_no');
    }
    public function price()
    {
        return $this->hasMany(Price::class, 'unit_id', 'unit_id');
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'unit_id', 'unit_id');
    }
     public function priceSingle()
    {
        return $this->belongsTo(Price::class, 'unit_id', 'unit_id');
    }
}
