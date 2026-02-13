<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class add_favorite extends Model
{
    use HasFactory;
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
}
