<?php


namespace App\Services\Subscription;


use Stripe\PromotionCode;
use Stripe\Stripe;

class CouponService
{
    /** @var string */
    protected $code;

    /**
     * @param string $code
     * @return $this
     */
    public function code(string $code): self
    {
        $this->code = strip_tags(trim($code, ' '));
        return $this;
    }

    /**
     * @return array
     */
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
            $promos = PromotionCode::all(['code' => $this->code]);
            if ($promos->count() !== 1) {
                return [
                    'valid' => false,
                    'error' => 'Invalid code',
                ];
            }

            /** @var PromotionCode $promo */
            $promo = $promos->first();
            if (!$promo->active) {
                return [
                    'valid' => false,
                    'error' => 'Not active',
                ];
            }

            // We have a valid coupon
            return [
                'valid' => $promo->active,
                'promotion' => $promo->id,
                'coupon' => $promo->coupon->id,
                'discount' => __('settings.subscription.coupon.percent_off', ['percent' => $promo->coupon->percent_off]),
            ];

        } catch(\Exception $e) {
            return [
                'valid' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
