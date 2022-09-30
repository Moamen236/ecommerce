<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'scrapped_quantity',
        'reduced_quantity',
        'base_quantity',
        'cost',
        'shipping_price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expiry_date' => 'datetime'
    ];

    /**
     * Get product
     * 
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get warehouse
     * 
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
