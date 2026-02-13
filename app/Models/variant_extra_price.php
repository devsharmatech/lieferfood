<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variant_extra_price extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(foodVariant::class,'variant_id');
    }
    public function extra(){
        return $this->belongsTo(collection_extra::class,'extra_id');
    }
}
