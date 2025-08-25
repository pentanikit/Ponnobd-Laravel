<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplaySection extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(ProductBySection::class, 'section_id', 'id');
    }
}
