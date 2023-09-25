<?php

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;

class PurchaseService
{

    public function calculatePrice(
        Product $product,
        Tax $tax,
        ?Coupon $coupon = null
    ): float
    {
        $priceWithTax = ($product->getPrice() * (1 + ($tax->getTaxPercent()/100)));

        return ($coupon) ? $coupon->getDiscountedPrice($priceWithTax) : $priceWithTax;
    }

}