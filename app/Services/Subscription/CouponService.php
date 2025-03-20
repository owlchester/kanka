<?php

namespace App\Services\Subscription;

use App\Enums\PricingPeriod;
use App\Traits\UserAware;
use Exception;
use Stripe\PromotionCode;
use Stripe\Stripe;

class CouponService
{
    use UserAware;

    protected string $code;

    protected \App\Models\Tier $tier;

    /**
     * @return $this
     */
    public function code(string $code): self
    {
        $this->code = strip_tags(mb_trim($code, ' '));

        return $this;
    }

    /**
     * @return $this
     */
    public function tier(\App\Models\Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function check(): array
    {
        if (empty($this->code)) {
            return [
                'valid' => false,
                'error' => 'Empty code',
            ];
        }

        try {
            Stripe::setApiKey(config('cashier.secret'));

            // We have to look at all codes with this coupon this way, because the retrieve method
            // expects a stripe_id
            $promos = PromotionCode::all(['code' => $this->code, 'active' => true]);
            if ($promos->count() !== 1) {
                return $this->error(__('subscriptions/promos.errors.invalid'));
            }

            /** @var PromotionCode $promo */
            $promo = $promos->first();
            if (! $promo->active) {
                return $this->error(__('subscriptions/promos.errors.inactive'));
            }

            // Check restrictions
            if ($promo->restrictions) {
                // Some promos are only for first time subscribers
                // @phpstan-ignore-next-line
                if ($promo->restrictions->first_time_transaction) {
                    if ($this->user->subscriptions->count()) {
                        return $this->error(__('subscriptions/promos.errors.only-new'));
                    }
                }
            }

            // We have a valid coupon
            return [
                'promo' => $promo,
                'valid' => $promo->active,
                'promotion' => $promo->id,
                'coupon' => $promo->coupon->id,
                'discount' => __('settings.subscription.coupon.percent_off', ['percent' => $promo->coupon->percent_off]),
                'price' => $this->price($promo),
            ];
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    protected function price($promo): string
    {
        $price = $this->tier->price($this->user->currency(), PricingPeriod::Yearly);

        $discount = round($price * ($promo->coupon->percent_off / 100), 2);
        $newPrice = $price - $discount;

        return '<del>' . number_format($price, 2) . '</del> ' . number_format($newPrice, 2);
    }

    protected function error(mixed $error): array
    {
        return [
            'valid' => false,
            'error' => $error,
        ];
    }
}
