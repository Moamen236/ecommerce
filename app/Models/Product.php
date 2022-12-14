<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\SubSubCategory;
use App\Models\ProductCategory;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends LocalizableModel implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'short_description_en',
        'short_description_ar',
        'description_en',
        'description_ar',
        'slug',
        'sku',
        'price',
        'total_quantity', 
        'expiry_alarm_before'
    ];

    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'description',
        'short_description'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'free_shipping' => 'boolean',
        'allow_review' => 'boolean',
        'active' => 'boolean'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('medium')
            ->width(1024)
            ->height(1024)
            ->nonQueued();
        $this->addMediaConversion('card')
            ->width(400)
            ->height(400)
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->width(160)
            ->height(160)
            ->nonQueued();
    }

    /**
     * The function to return Images.
     *
     */
    public function getImagesAttribute()
    {
        $images = $this->getMedia('product.images');
        foreach ($images as $image) {
            $image->url = $image->getUrl('card');
            $image->medium_size_url = $image->getUrl('medium');
            $image->original_size_url = $image->getUrl();
        }
        return $images;
    }

    /**
     * Get Brand
     * 
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get product categories
     * 
     */
    public function categories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'product_categories', 'product_id', 'sub_sub_category_id')->using(ProductCategory::class)->withTimestamps();
    }

    /**
     * get Warehouses
     * 
     */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_products');
    }

    /**
     * get reviews
     * 
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Get product active categories
     * 
     */
    public function active_categories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'product_categories', 'product_id', 'sub_sub_category_id')->withTimestamps()->active();
    }

    /**
     * add slug attribute to the Product.
     *
     */
    public function addSlugAttribute()
    {
        $name = $this->name_en ? $this->name_en : $this->name_ar;
        $slug = Str::slug($name);
        if (Product::where('slug', $slug)->exists())
            $slug .= '-' . $this->id;

        $this->slug = $slug;
        $this->save();
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query)
    {
        $query->where('active', 1)
            ->where('total_quantity', '>', 0)
            ->where('final_price', '>', 0);
    }
    
}
