<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliment extends Model
{
    use HasFactory;
    public function collection_data(){
        return $this->belongsTo(collections::class,'collection_id');
    }
}
