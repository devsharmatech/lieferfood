<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    public function deal(){
        return $this->belongsTo(Groups::class,'deal_id');
    }
    public function foodData(){
        return $this->belongsTo(food_item::class,'food_id');
    }
    public function food(){
        return $this->belongsTo(food_item::class,'food_id');
    }
}
