<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foodVariant extends Model
{
    use HasFactory;
    public function food_item(){
        return $this->belongsTo(food_item::class,'food_id');
    }
    public function variant_item(){
        return $this->belongsTo(CategoryVariant::class,'variant_id');
    }
}
