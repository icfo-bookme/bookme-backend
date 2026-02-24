<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSectionSetting extends Model
{
    use HasFactory;

    protected $table = 'homepage_section_setting';

    protected $fillable = [
        'heading',
        'category',
        'subcategory',
        'limit',
        'order',
        'active'
    ];

    protected $casts = [
       
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Convert the active enum to boolean
     */
   // In Setting.php (Model)
public function setActiveAttribute($value)
{
    $this->attributes['active'] = strtolower(trim($value));
}


  
}