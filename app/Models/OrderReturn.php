<?php

namespace App\Models;

use App\Enums\ReturnStatusName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;

    /**
     * Table name because return string is preserved word
     */
    protected $table = 'returns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'price',
        'comment',
    ];

    /**
     * Get order warehouse
     * 
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class, 'warehouse_id');
    }

    /**
     * Get User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Get Order
     * 
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get product
     * 
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get statuses
     * 
     */
    public function statuses()
    {
        return $this->hasMany(ReturnStatus::class, 'order_id');
    }

    /**
     * Get order latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(ReturnStatus::class)->orderBy('id', 'desc');
    }

    /**
     * if order has Pending status
     * 
     */
    public function isPending()
    {
        return $this->statuses->where('name', ReturnStatusName::Pending)->isNotEmpty();
    }

    /**
     * if order has approved status
     * 
     */
    public function isApproved()
    {
        return $this->statuses->where('name', ReturnStatusName::Approved)->isNotEmpty();
    }

    /**
     * if order has Disapproved status
     * 
     */
    public function isDisapproved()
    {
        return $this->statuses->where('name', ReturnStatusName::Disapproved)->isNotEmpty();
    }

    /**
     * if order has Completed status
     * 
     */
    public function isCompleted()
    {
        return $this->statuses->where('name', ReturnStatusName::Completed)->isNotEmpty();
    }

    /**
     * if order has InTheWay status
     * 
     */
    public function isInTheWay()
    {
        return $this->statuses->where('name', ReturnStatusName::InTheWay)->isNotEmpty();
    }

    /**
     * if order has ReturnDenied status
     * 
     */
    public function isReturnDenied()
    {
        return $this->statuses->where('name', ReturnStatusName::ReturnDenied)->isNotEmpty();
    }

    /**
     * if order has Canceled status
     * 
     */
    public function isCanceled()
    {
        return $this->statuses->where('name', ReturnStatusName::Canceled)->isNotEmpty();
    }

}
