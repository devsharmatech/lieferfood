<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class food_item extends Model
{
    use HasFactory;

    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function collections(){
        return $this->belongsTo(collections::class,'collection');
    }
   
    public function variants()
    {
        return $this->hasMany(foodVariant::class, 'food_id');
    }
   
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
    public function offer(){
        return $this->hasOne(offer::class, 'food_id')->where('start_date', '<=', now())->where('start_date', '<=', now())->where('end_date', '>', now())->where('is_active',1) ;
    }
    
   
    
}
