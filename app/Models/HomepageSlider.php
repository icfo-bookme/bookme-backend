<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageSlider extends Model
{
    use HasFactory;

    // If your table name is not the plural of your model name, define it:
    protected $table = 'hot_pack';

    // If you don't want timestamps (created_at/updated_at) handled automatically:
    public $timestamps = true;

    // Define which attributes are mass assignable
    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'btn_link',
        'discounts',
        'created_at',
        'updated_at'
    ];
}
