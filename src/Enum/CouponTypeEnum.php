<?php

namespace App\Enum;

enum CouponTypeEnum: string
{

    case FIXED_AMOUNT = 'fixed';
    case AMOUNT_PERCENT = 'percent';

}