<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlider extends Model
{
    protected $table = 'carousel_slider';

    protected $fillable = [
        'image', 'destination_id', 'title', 'subtitle'
    ];
}
