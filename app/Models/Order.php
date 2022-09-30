<?php

namespace App\Models;

use App\Enums\OrderStatusName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shipping_price',
        'shipping_date',
        'comment',
        'payment_method',
    ];

    /**
     * Get products
     * 
     */
    public function products()
    {
        return $this->belongsToMany(Product::class,'orders_products', 'order_id', 'product_id')
        ->withPivot(['quantity', 'price', 'old_price'])
        ->using(OrderProduct::class)->withTimestamps();
    }

    /**
     * Get statuses
     * 
     */
    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    /**
     * Get order latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(OrderStatus::class)->orderBy('id', 'desc');
    }

    /**
     * Get user
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get user address
     * 
     */
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    /**
     * Get order warehouse
     * 
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class, 'warehouse_id');
    }

    /**
     * Get order returns
     *
     */
    public function returns()
    {
        return $this->hasMany(OrderReturn::class, 'order_id');
    }

    /**
     * if order has Pending status
     * 
     */
    public function isPending()
    {
        return $this->statuses->where('name', OrderStatusName::Pending)->isNotEmpty();
    }

    /**
     * if order has approved status
     * 
     */
    public function isApproved()
    {
        return $this->statuses->where('name', OrderStatusName::Approved)->isNotEmpty();
    }

    /**
     * if order has prepared status
     * 
     */
    public function isPrepared()
    {
        return $this->statuses->where('name', OrderStatusName::Prepared)->isNotEmpty();
    }

    /**
     * if order has Disapproved status
     * 
     */
    public function isDisapproved()
    {
        return $this->statuses->where('name', OrderStatusName::Disapproved)->isNotEmpty();
    }

    /**
     * if order has Completed status
     * 
     */
    public function isCompleted()
    {
        return $this->statuses->where('name', OrderStatusName::Completed)->isNotEmpty();
    }

    /**
     * if order has Shipped status
     * 
     */
    public function isShipped()
    {
        return $this->statuses->where('name', OrderStatusName::Shipped)->isNotEmpty();
    }

    /**
     * if order has ShippingReturned status
     * 
     */
    public function isShippingReturned()
    {
        return $this->statuses->where('name', OrderStatusName::ShippingReturned)->isNotEmpty();
    }

    /**
     * if order has Canceled status
     * 
     */
    public function isCanceled()
    {
        return $this->statuses->where('name', OrderStatusName::Canceled)->isNotEmpty();
    }

    /**
     * if order has Returned status
     * 
     */
    public function isReturned()
    {
        return $this->statuses->where('name', OrderStatusName::Returned)->isNotEmpty();
    }

    /**
     * if order has Deleted status
     * 
     */
    public function isDeleted()
    {
        return $this->statuses->where('name', OrderStatusName::Deleted)->isNotEmpty();
    }
}
