<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAttribute extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default
    protected $table = 'contact_attributes'; 

    // Specify the primary key if it's different from 'id'
    protected $primaryKey = 'contact_id';

    // Set the primary key to be composite (contact_id, attribute_name)
    public $incrementing = true;

    // Allow mass assignment on these columns
    protected $fillable = [ 'attribute_name', 'value'];

    // Cast the created_at field as a datetime object
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
