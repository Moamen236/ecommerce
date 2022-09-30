<?php

namespace App\Enums;

abstract class ReturnStatusName {
    const Pending = 'Waiting for confirmation';
    const Approved = 'Approved';
    const Disapproved = 'Disapproved';
    const Completed = 'Completed';
    const InTheWay = 'In the way';
    const ReturnDenied = 'Return denied';
    const Canceled = 'Canceled';
}