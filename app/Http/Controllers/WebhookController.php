<?php

namespace App\Http\Controllers;

use App\Enums\UserAction;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use App\Services\Subscription\PaymentMethodService;
use App\Services\SubscriptionService;
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
            if ($status != 'past_due' && ! $this->isCancelling($payload)) {
                $service->user($user)->webhook()
                    ->plan($payload['data']['object']['plan']['id'])
                    ->finish();
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
            MailSettingsChangeJob::dispatch($user);
        }

        return $response;
    }

    /**
     * Check if a request is to cancel a user
     */
    protected function isCancelling(array $data): bool
    {
        // Log::debug('data', $data);
        $cancel = Arr::get($data, 'object.canceled_at', null);
        $previousCancel = Arr::get($data, 'previous_attributes.canceled_at', null);

        return ! empty($cancel) && empty($previousCancel);
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
            $paymentService->updateExpiry($user, UserAction::paymentAuto);
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
            $paymentService->updateExpiry($user, UserAction::paymentEdit);
        }

        return $this->successMethod();
    }
}
