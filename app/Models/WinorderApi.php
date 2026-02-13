<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinorderApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'vendor_id',
        'code',
        'secret_key',
        'status',
        'error_msg',
        'created_at',
        'updated_at',
    ];
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
}
