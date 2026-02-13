<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collections extends Model
{
    use HasFactory;
    public function food_items()
    {
        return $this->hasMany(food_item::class, 'collection');
    }
    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }
    
    public function collection_items()
    {
        return $this->hasMany(CollectionItem::class, 'collection_id');
    }
}
