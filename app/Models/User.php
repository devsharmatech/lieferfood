<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function vendor_details()
    {

        return $this->hasOne(vendor_detail::class, 'vendor_id', 'id');
    }
    public function table_service()
    {
        return $this->hasOne(table_service::class, 'vendor_id', 'id');
    }
    public function delivery_address()
    {
        return $this->hasOne(address::class, 'user_id', 'id');
    }
    public function offers()
    {

        return $this->hasMany(offer::class, 'created_by', 'id');
    }
    public function offer()
    {
      return $this->hasOne(offer::class, 'created_by', 'id')->latest();
    }
    public function favorites()
    {
        return $this->hasMany(add_favorite::class, 'vendor_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(review::class,'vendor_id');
    }
    public function vendor_opening_times()
    {
        return $this->hasMany(VendorOpeningTime::class,'vendor_id')->orderBy('id','ASC');
    }
    public function delivery_areas()
    {
        return $this->hasMany(DeliveryArea::class,'vendor_id')->orderBy('area_name','ASC');
    }
    
    public function permissions()
    {
      return $this->belongsToMany(Permission::class, 'user_permissions');
    }
    public function winorderApi()
    {
    return $this->hasOne(WinorderApi::class, 'vendor_id', 'id'); 
    }
    public function document()
    {
    return $this->hasOne(VendorDocument::class, 'vendor_id', 'id'); 
    }
}
