<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function subcategories()
    {
        return $this->hasMany(ExpenseSubcategory::class, 'category_id');
    }
}
