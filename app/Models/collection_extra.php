<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collection_extra extends Model
{
    use HasFactory;
    public function collection_data()
    {
        return $this->belongsTo(collections::class, 'collection_id');
    }
    public function variantPrices(){
        return $this->hasMany(variant_extra_price::class, 'extra_id');
    }
}
