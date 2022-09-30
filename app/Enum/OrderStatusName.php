<?php

namespace App\Enums;

abstract class OrderStatusName
{
    const Pending = 'Waiting for confirmation';
    const Approved = 'Approved';
    const Prepared = 'Prepared';
    const Disapproved = 'Disapproved';
    const Completed = 'Completed';
    const Shipped = 'Shipped';
    const ShippingReturned = 'Shipping returned';
    const Canceled = 'Canceled';
    const Returned = 'Returned';
    const Deleted = 'Deleted';
}
