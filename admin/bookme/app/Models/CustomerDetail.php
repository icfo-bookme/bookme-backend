<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;

    protected $table = 'customer_details';

    protected $fillable = [
        'customer_id',
        'given_name',
        'surname',
        'gender',
        'phone_number',
        'date_of_birth',
        'nationality',
        'address',
        'post_code',
        'passport_number',
        'passport_expiry_date',
        'passport_document_url',
        'visa_document',
        'profile_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_expiry_date' => 'date',
    ];
}
