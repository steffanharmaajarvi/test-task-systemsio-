<?php

declare(strict_types=1);

namespace App\PaymentProcessor;

use Exception;

class StripePaymentProcessor
{
    /**
     * @param float $price payment amount in currency
     * @return bool true if payment was succeeded, false otherwise
     */
    public function processPayment(float $price): bool
    {
        if ($price < 100) {
            return false;
        }

        //process payment logic
        return true;
    }
}