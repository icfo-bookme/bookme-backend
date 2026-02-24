<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
   protected $table = 'schedule'; 
    protected $fillable = [
        'property_id',
        'depart_date',
        'depart_time',
        'return_date',
        'return_time',
    ];
}
