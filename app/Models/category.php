<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    public function category_variants()
    {
        return $this->hasMany(CategoryVariant::class, 'category_id');
    }
    public function food_items()
    {
        return $this->hasMany(food_item::class, 'category_id');
    }
    public function offer()
    {
        return $this->hasOne(offer::class, 'category_id')->where('start_date', '<=', now())->where('start_date', '<=', now())->where('end_date', '>', now())->where('is_active',1) ;
    }
}
