<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_destination extends Model
{
    use HasFactory;

   
    public $timestamps = false; 
    protected $fillable = ['name', 'country','img'];
}
