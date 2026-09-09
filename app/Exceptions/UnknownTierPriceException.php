<?php

namespace App\Exceptions;

use RuntimeException;

class UnknownTierPriceException extends RuntimeException
{
    public static function forStripePrice(string $stripePrice): self
    {
        return new self("Stripe price [{$stripePrice}] is not mapped to a tier price.");
    }
}
