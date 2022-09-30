<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends LocalizableModel implements HasMedia
{
    use HasFactory, 
        HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'navbar_visibility',
        'active',
    ];

    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'description'
    ];

    /**
     * Get products
     * 
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /**
     * Get active products
     * 
     */
    public function active_products()
    {
        return $this->products()->active();
    }

    /**
     * add slug attribute to the brand.
     *
     */
    public function addSlugAttribute()
    {
        $name = $this->name_en ? $this->name_en : $this->name_ar;
        $slug = Str::slug($name);
        if (Brand::where('slug', $slug)->exists())
            $slug .= '-' . $this->id;

        $this->slug = $slug;
        $this->save();
    }

    /**
     * Scope a query to only include active brands.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
