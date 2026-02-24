<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourConsultationRequest extends Model
{
    use HasFactory;

    protected $table = 'tour_consultation_requests';

    protected $fillable = [
        'name',
        'number',
        'address',
        'additional_info',
        'property_name',
        'category',
        'verified_by'
    ];
}
