<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_food extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(category::class,'category_id','id');
    }
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id','id');
    }
}
