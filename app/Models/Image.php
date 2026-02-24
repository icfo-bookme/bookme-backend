<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images'; // Optional, defaults to plural of model name
public $timestamps = false;
    // Fillable attributes for mass assignment
    protected $fillable = [
        'file_name',
    ];
}
