<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customeOpening extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'is_pickup', 'is_delivery', 'open_date', 'delivery_times', 'pickup_times'
    ];
}
