<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasFactory;
    public function sub_items(){
        return $this->belongsTo(FoodSubItem::class,'item_id');
    }
    
     public function collectionData(){
        return $this->belongsTo(collections::class,'collection_id');
    }
}
