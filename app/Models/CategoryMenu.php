<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMenu extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->hasOne(CategoryMenu::class,'id','parent_id');
    }

    public function parents()
    {
        return $this->hasMany(CategoryMenu::class,'parent_id','id')->with('parents');
    }
}
