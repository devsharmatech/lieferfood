<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupItems extends Model
{
    use HasFactory;
    public function food_item(){
        return $this->belongsTo(food_item::class,'menu_item_id');
    }
   
    public function group()
    {
        return $this->belongsTo(Groups::class,'group_id');
    }

    
}
