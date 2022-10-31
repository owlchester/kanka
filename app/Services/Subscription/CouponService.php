<?php


namespace App\Services\Subscription;


use App\User;
use Stripe\PromotionCode;
use Stripe\Stripe;

class CouponService
{
    protected string $code;

    protected User $user;

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
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
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
            $promos = PromotionCode::all(['code' => $this->code, 'active' => true]);
            if ($promos->count() !== 1) {
                return $this->error(__('subscriptions/promos.errors.invalid'));
            }

            /** @var PromotionCode $promo */
            $promo = $promos->first();
            if (!$promo->active) {
                return $this->error(__('subscriptions/promos.errors.inactive'));
            }

            // Check restrictions
            if ($promo->restrictions) {
                // Some promos are only for first time subscribers
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
            ];

        } catch(\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param mixed $error
     * @return array
     */
    protected function error(mixed $error): array
    {
        return [
            'valid' => false,
            'error' => $error
        ];
    }
}
