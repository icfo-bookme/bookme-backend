<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destination';
    protected $primaryKey = 'destination_id';
    public $incrementing = true;
    protected $fillable = [
        'destination_name', 
        'district_city', 
        'img', 
        'isactive', 
       
     
    ];

    public $timestamps = true;
}
