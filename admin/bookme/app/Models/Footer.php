<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'terms',
        'talent_and_culture',
        'refund_policy',
        'emi_policy',
        'privacy_policy',
    ];
}
