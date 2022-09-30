<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
    ];

    /**
     * Get city
     * 
     */
    public function city()
    {
       return $this->belongsTo(City::class); 
    }

    /**
     * Get locations
     * 
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
