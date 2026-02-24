<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubcategory extends Model
{
    protected $fillable = ['category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'subcategory_id');
    }
}
