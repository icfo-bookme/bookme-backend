<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Table name (optional if follows Laravel convention)
    protected $table = 'notifications';

    // Mass assignable fields
    protected $fillable = [
        'notification',
        'isActive',
        'redirectUrl',
    ];

    // Cast fields to specific types
    protected $casts = [
        'isActive' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
