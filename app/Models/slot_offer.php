<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class slot_offer extends Model
{
    use HasFactory;
    public function slot(){
        return $this->belongsTo(VendorTableTime::class,'slot_id');
    }
}
