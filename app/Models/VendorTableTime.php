<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTableTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'is_table', 'day', 'table_times'
    ];

    protected $casts = [
        'table_times' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id');
    }
     public function offers(){
        return $this->hasMany(slot_offer::class,'slot_id');
    }
    
}
