<?php

namespace App\Enum;

abstract class OrderPaymentType
{
    const cash_on_delivery = "COD";
    const pay_from_balance = "pay_from_balance";
    const credit_card = "credit_card";
}