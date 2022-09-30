<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
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
     * Get Category
     * 
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get sub sub category
     * 
     */
    public function subSubCategory()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    /**
     * Get active sub sub category
     * 
     */
    public function active_sub_sub_categories()
    {
        return $this->hasMany(SubSubCategory::class)->active();
    }

    /**
     * Get visible sub sub category
     *
     */
    public function visible_sub_sub_categories()
    {
        return $this->hasMany(SubSubCategory::class)->active()->where('navbar_visibility', 1);
    }

    /**
     * add slug attribute to the sub Category.
     *
     */
    public function addSlugAttribute()
    {
        $name = $this->name_en ? $this->name_en : $this->name_ar;
        $slug = Str::slug($name);
        if (SubCategory::where('slug', $slug)->exists())
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
