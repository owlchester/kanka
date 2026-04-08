<?php

namespace App\Services\Subscription;

use App\Enums\UserAction;
use App\Models\Tier;
use App\Traits\UserAware;
use Srmklive\PayPal\Services\PayPal;

class PayPalRenewalService
{
    use UserAware;

    protected Tier $tier;

    public function tier(Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function process(): mixed
    {
        $currency = 'USD';
        if ($this->user->billedInEur()) {
            $currency = 'EUR';
        }

        $price = $this->tier->yearly;

        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        return $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.renew-success'),
                'cancel_url' => route('paypal.renew-cancel'),
            ],
            'purchase_units' => [
                0 => [
                    'reference_id' => $this->tier->name,
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $price,
                    ],
                ],
            ],
        ]);
    }

    public function renew(Tier $tier): void
    {
        $sub = $this->user->subscriptions()->first();
        $sub->ends_at = $sub->ends_at->addYear();
        $sub->stripe_price = 'paypal_' . $tier->code;
        $sub->save();

        $this->user->pledge = $tier->name;
        $this->user->save();

        $this->user->log(UserAction::subPaypalRenew);
    }
}
