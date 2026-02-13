<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'message', 'payout_by', 'amount', 'paypal_commission', 
        'commission', 'card_commission', 'payment_date', 'payment_detail', 'account_detail','payout_amount','paypal_amount','order_from','order_till'
    ];
    public function invoice()
    {
        return $this->hasOne(Invoice::class,'payout_id')->latest();
    }

    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id');
    }
}
