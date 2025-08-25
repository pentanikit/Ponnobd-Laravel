<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function scopeFeatured(Builder $query)
    {
        $query->where('featured', '1');
    }

    public function getIcon()
    {
        return asset($this->icon);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(ProductCategories::class, 'category_id', 'id');
    }
}
