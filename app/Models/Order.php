<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function order_items(){
        return $this->hasMany(Order_item::class,'order_id');
    }
    public function items(){
        return $this->hasMany(Order_item::class,'order_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function review(){
        return $this->hasOne(review::class,'order_id');
    }
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
}
