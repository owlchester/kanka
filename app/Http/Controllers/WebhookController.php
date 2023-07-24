<?php

namespace App\Http\Controllers;

use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\SubscriptionSource;
use App\Models\UserLog;
use App\Services\Subscription\PaymentMethodService;
use App\Services\SubscriptionService;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle an updated subscription (for example when managing 3d secure payments)
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        // Call parent handler method
        $response = parent::handleCustomerSubscriptionUpdated($payload);

        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            /** @var SubscriptionService $service */
            $service = app()->make('App\Services\SubscriptionService');

            $data = $payload['data']['object'];
            $status = Arr::get($data, 'status', false);

            Log::debug('Customer Sub Updated Status ' . $status);

            // If the status is past_due, we need to remind the user to update their credit card info.
            // Also if the user is cancelling, we've already handled that in Kanka, we don't need to handle it here, but
            // stripe will still tell us about it.
            if ($status != 'past_due' && !$this->isCancelling($payload)) {
                $service->user($user)->webhook()->finish($payload['data']['object']['plan']['id']);
            }
        }
        return $response;
    }

    /**
     * Handle a deleted subscription
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        // Call parent handler method
        $response = parent::handleCustomerSubscriptionDeleted($payload);

        // User notification. Maybe even an email
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            // Notify admin
            SubscriptionDeletedEmailJob::dispatch($user);
            // Cleanup the user "now". This used to have a delay, but if Stripe is calling this endpoint,
            // it's that the user's sub has ended.
            SubscriptionEndJob::dispatch($user);
        }

        return $response;
    }

    /**
     * For users using sofort, ideal etc, we need to handle this async call
     * @param array $payload
     */
    public function handleSucceededCharge(array $payload)
    {
        // User notification. Maybe even an email
        Log::debug('succeeded charge', $payload);
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            $charge = $payload['data']['object']['charge'];

            $source = SubscriptionSource::where(['user_id' => $user->id, 'charge_id', $charge])->first();
            if ($source) {
                // Do something?
            }
        }

        return $this->successMethod();
    }

    public function handleSourceChargeable(array $payload)
    {
        /** @var SubscriptionService $subscription */
        $subscription = app()->make(SubscriptionService::class);

        $subscription
            ->sourceCharge($payload);

        return $this->successMethod();
    }

    /**
     * Charge Failed can happen on any medium (cc, sofort, giropay)
     * @param array $payload
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleChargeFailed(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            /** @var SubscriptionService $subscription */
            $subscription = app()->make(SubscriptionService::class);
            $subscription
                ->user($user)
                ->webhook()
                ->chargeFailed($payload);
        }
        return $this->successMethod();
    }

    /**
     * Check if a request is to cancel a user
     * @param array $data
     * @return bool
     */
    protected function isCancelling(array $data): bool
    {
        //Log::debug('data', $data);
        $cancel = Arr::get($data, 'object.canceled_at', null);
        $previousCancel = Arr::get($data, 'previous_attributes.canceled_at', null);

        return !empty($cancel) && empty($previousCancel);
    }

    /**
     * Handle payment method automatically updated by vendor.
     */
    protected function handlePaymentMethodAutomaticallyUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            $user->updateDefaultPaymentMethodFromStripe();

            /** @var PaymentMethodService $paymentService */
            $paymentService = app()->make(PaymentMethodService::class);
            $paymentService->updateExpiry($user, UserLog::TYPE_PAYMENT_AUTO);
        }

        return $this->successMethod();
    }

    /**
     * Handle payment method updated by vendor.
     */
    protected function handlePaymentMethodUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var User $user */
            $user->updateDefaultPaymentMethodFromStripe();

            /** @var PaymentMethodService $paymentService */
            $paymentService = app()->make(PaymentMethodService::class);
            $paymentService->updateExpiry($user, UserLog::TYPE_PAYMENT_EDIT);
        }

        return $this->successMethod();
    }
}
