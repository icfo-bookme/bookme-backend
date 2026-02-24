<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['category_id','subcategory_id', 'amount', 'expense_date', 'description'];

    public function subcategory()
    {
        return $this->belongsTo(ExpenseSubcategory::class, 'subcategory_id');
    }
    public function category()
{
    return $this->belongsTo(ExpenseCategory::class);
}


}
