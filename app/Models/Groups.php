<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    public function groupItems()
    {
        return $this->hasMany(GroupItems::class,'group_id');
    }
    public function menuItems()
    {
        return $this->belongsToMany(food_item::class, 'group_items','group_id', 'menu_item_id');
    }
}
