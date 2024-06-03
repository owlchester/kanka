<?php

namespace App\Enums;

enum PricingPeriod: int
{
    case Monthly = 1;
    case Yearly = 2;

    public function isYearly(): bool
    {
        return match ($this) {
            PricingPeriod::Yearly => true,
            default => false,
        };
    }

    public function lowerName(): string
    {
        return mb_strtolower($this->name);
    }
}
