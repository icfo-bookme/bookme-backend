<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFeature extends Model
{
    use HasFactory;

    protected $table = 'room_features';
 public $timestamps = false;
    protected $fillable = [
        'feature_id',
        'isfeature',
        'isfeature_summary',
        'room_id'
    ];

    protected $casts = [
        'isfeature' => 'boolean',
        'isfeature_summary' => 'boolean'
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}