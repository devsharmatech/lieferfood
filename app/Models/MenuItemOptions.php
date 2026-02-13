<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemOptions extends Model
{
    use HasFactory;
    public function food_item(){
        return $this->belongsTo(food_item::class,'menu_item_id');
    }

    public function optionValues()
    {
        return $this->hasMany(MenuItemOptionValues::class, 'menu_item_option_id');
    }

}
