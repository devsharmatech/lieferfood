<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offer extends Model
{
    use HasFactory;
    
    public function createdby(){
        return $this->belongsTo(User::class,'created_by');
    }
    
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
    
    public function food(){
        return $this->belongsTo(food_item::class,'food_id');
    }
    
    public function slots(){
        return $this->hasMany(OfferTimeSlot::class,'offer_id');
    }
}
