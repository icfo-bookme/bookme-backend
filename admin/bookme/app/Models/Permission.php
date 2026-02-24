<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'module', 'label'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
