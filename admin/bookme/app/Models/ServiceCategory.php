<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $table = 'service_category';  
    protected $primaryKey = 'category_id';  

    public $timestamps = true; 

    protected $fillable = [
        'category_name', 
        'description', 
        'img', 
        'serialno', 
        'isactive', 
         'isShow', 
        
    ];

}
