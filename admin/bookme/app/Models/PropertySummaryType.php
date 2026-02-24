<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySummaryType extends Model
{
    use HasFactory;

    protected $table = 'property_summary_type'; // explicitly define table if not plural

    protected $fillable = [
        'name',
        'service_category_id',
    ];

    /**
     * Optional: Define relationship to ServiceCategory
     */
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
