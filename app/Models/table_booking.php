<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_booking extends Model
{
    use HasFactory;
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function foods()
    {
        return $this->hasMany(table_food::class, 'id', 'food_id');
    }
}
