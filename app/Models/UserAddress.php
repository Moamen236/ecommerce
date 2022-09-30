<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street',
        'building',
        'floor',
        'apartment',
        'nearest_landmark',
        'location_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_main_address' => 'boolean',
    ];

    /**
     * Get User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get City
     * 
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get District
     * 
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get Location
     * 
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
