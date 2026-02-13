<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemOptionValues extends Model
{
    use HasFactory;
    public function menuItemOption()
    {
        return $this->belongsTo(MenuItemOptions::class, 'menu_item_option_id');
    }
}
