<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class slots extends Model
{
    use HasFactory;

    public function offers(){
        return $this->hasMany(slot_offer::class,'slot_id');
    }
}
