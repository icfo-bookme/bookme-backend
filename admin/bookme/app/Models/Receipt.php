<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';

    protected $fillable = [
        'payment_id',
        'customer_id',
        'receipt_number',
        'issued_date',
        'generated_by',
        'total_payable',
        'paid_amount',
        'special_discount',
        'balance_due',
        'notes',
    ];

    // 👇 Auto-casting for numeric values
    protected $casts = [
        'issued_date' => 'date',
        'total_payable' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'special_discount' => 'decimal:2',
        'balance_due' => 'decimal:2',
    ];

    // 👇 Example relationships (optional)
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
