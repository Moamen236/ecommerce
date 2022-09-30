<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubSubCategory extends Model
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
        'description_en',
        'description_ar',
        'slug',
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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'navbar_visibility' => 'boolean',
        'active' => 'boolean'
    ];

    /**
     * Get sub category
     * 
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }   

    /**
     * Get Products
     * 
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'sub_sub_category_id', 'product_id');
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
     * add slug attribute to the sub Category.
     *
     */
    public function addSlugAttribute()
    {
        $name = $this->name_en ? $this->name_en : $this->name_ar;
        $slug = Str::slug($name);
        if (SubSubCategory::where('slug', $slug)->exists())
            $slug .= '-' . $this->id;

        $this->slug = $slug;
        $this->save();
    }

    /**
     * Scope a query to only include active sub categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
