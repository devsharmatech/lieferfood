<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'payout_id', 'pdf'];

    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id'); 
    }
}
