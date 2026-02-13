<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOpeningTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'is_pickup', 'is_delivery', 'day', 'delivery_times', 'pickup_times'
    ];

    protected $casts = [
        'delivery_times' => 'array',
        'pickup_times' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id');
    }
}
