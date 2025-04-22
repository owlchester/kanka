<?php

namespace App\Services;

use App\Models\Tier;
use App\Traits\UserAware;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;
use Srmklive\PayPal\Services\PayPal;

class PayPalService
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
        if ($this->user->isSubscriber() && ! $this->user->hasPayPal()) {
            return [];
        }
        $oldPrice = '';
        $currency = 'USD';
        if ($this->user->billedInEur()) {
            $currency = 'EUR';
        }
        $price = $this->tier->yearly;

        if ($this->user->isSubscriber()) {
            if ($this->user->isElemental()) {
                return [];
            } elseif ($this->user->isOwlbear()) {
                $tier = Tier::where('code', 'owlbear')->first();
                $oldPrice = $tier->yearly;
            } elseif ($this->user->isWyvern()) {
                $tier = Tier::where('code', 'wyvern')->first();
                $oldPrice = $tier->yearly;
            }
            // @phpstan-ignore-next-line
            $price = round(($price - ($oldPrice)) * ($this->user->subscriptions()->first()->ends_at->diffInDays(Carbon::now(), true) / 365), 2);
        }
        $price = max(0, $price);

        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.transaction-success'),
                'cancel_url' => route('paypal.cancel-transaction'),
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

        return $response;
    }

    public function subscribe(string $pledge): void
    {
        if (! $this->user->isSubscriber()) {
            // Add the subscriber role
            $this->user->roles()->syncWithoutDetaching([5]);

            // Add the subscription to the user level
            $this->user->pledge = $pledge;
            $this->user->save();

            $sub = new Subscription;
            $sub->user_id = $this->user->id;
            $sub->type = 'kanka';
            $sub->stripe_id = 'paypal_' . uniqid();
            $sub->stripe_status = 'canceled';
            $sub->stripe_price = 'paypal_' . $this->user->pledge;
            $sub->quantity = 1;
            $sub->ends_at = Carbon::now()->addYear();
            $sub->save();
        } else {
            // Add the subscription to the user level
            $this->user->pledge = $pledge;
            $this->user->save();

            $sub = $this->user->subscriptions()->first();
            $sub->stripe_price = 'paypal_' . $this->user->pledge; // @phpstan-ignore-line
            $sub->save();
        }
        $this->user->log(UserLog::TYPE_SUB_PAYPAL);
    }
}
