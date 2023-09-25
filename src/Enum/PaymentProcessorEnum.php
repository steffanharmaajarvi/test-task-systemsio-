<?php

namespace App\Enum;

enum PaymentProcessorEnum: string
{

    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';

    public static function fromString(string $paymentProcessor): PaymentProcessorEnum
    {
        foreach (static::cases() as $paymentProcessorEnum) {
            if ($paymentProcessorEnum->value === $paymentProcessor) {
                return $paymentProcessorEnum;
            }
        }

        throw new \Exception('PaymentProcessor not found');
    }

}
