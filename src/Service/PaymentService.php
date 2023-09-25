<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentProcessorEnum;
use App\PaymentProcessor\PaypalPaymentProcessor;
use App\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{

    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor,
        private StripePaymentProcessor $stripePaymentProcessor,
    )
    {
    }

    public function pay(
        float $amount,
        PaymentProcessorEnum $paymentProcessorEnum,
    ): bool
    {
        if ($paymentProcessorEnum === PaymentProcessorEnum::STRIPE) {
            return $this->stripePaymentProcessor->processPayment($amount);
        } else if ($paymentProcessorEnum === PaymentProcessorEnum::PAYPAL) {
            $this->paypalPaymentProcessor->pay((int)ceil($amount));
        }

        return true;
    }

}