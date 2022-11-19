<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, 
        HasFactory, 
        Notifiable, 
        HasRoles, 
        HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The function to return Full name.
     *
     */
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * get reviews
     * 
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * get orders
     * 
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get user personal info
     * 
     */
    public function personalInfo()
    {
        return $this->hasOne(UserPersonalInfo::class);
    }

    /**
     * get orders
     * 
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * get user cart
     * 
     */
    public function cart()
    {
        return $this->belongsToMany(Product::class, 'user_carts', 'user_id', 'product_id')->active()->withPivot('quantity')->withTimestamps();
    }

    /**
     * get user wishlist
     * 
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'user_wishlists', 'user_id', 'product_id')->active()->withTimestamps();
    }

    /**
     * Get user approved reviews
     * 
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->approved();
    }

    /**
     * Get user not approved reviews
     * 
     */
    public function notApprovedReviews()
    {
        return $this->hasMany(Review::class)->where('approved', 0);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
