<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens, 
        HasFactory, 
        Notifiable, 
        HasRoles, 
        HasMediaTrait;

    /**
     * The attribute that auth guard.
     *
     * @var string
     */
    protected $guard_name = 'admin';

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
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean'
    ];

    /**
     * Get admin personal info
     * 
     */
    public function personalInfo()
    {
        return $this->hasOne(AdminPersonalInfo::class, 'admin_id');
    }

    /**
     * Get admin warehouses
     * 
     */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'admin_warehouses');
    }

    public function settings()
    {
        return $this->hasOne(AdminSetting::class, 'admin_id');
    }

    /**
     * Get admin full name
     * 
     */
    public function name()
    {
        return ucfirst($this->first_name). ' ' . ucfirst($this->last_name);
    }
}
