<?php

namespace App\Http\Controllers;

use App\Enums\UserAction;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Jobs\SubscriptionEndJob;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\Subscription\PaymentMethodService;
use App\Services\SubscriptionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;

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
                // Don't skip emails when a subscription transitions from incomplete to active
                // (e.g. PayPal or 3D Secure card flows where Stripe confirms asynchronously)
                $previousStatus = Arr::get($payload, 'data.previous_attributes.status', null);
                $isNewActivation = $previousStatus === 'incomplete' && $status === 'active';

                // plan.id is deprecated; fall back to items for newer subscriptions
                $planId = Arr::get($data, 'plan.id') ?? Arr::get($data, 'items.data.0.price.id');

                $serviceCall = $service->user($user)
                    ->plan($planId);

                if (! $isNewActivation) {
                    $serviceCall->webhook();
                }

                $serviceCall->finish();
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
     * Handle an upcoming invoice (yearly renewal warning).
     */
    public function handleInvoiceUpcoming(array $payload): Response
    {
        $data = $payload['data']['object'];
        $user = $this->getUserByStripeId($data['customer'] ?? null);

        if (! $user) {
            return $this->successMethod();
        }

        /** @var User $user */
        $yearlyPlans = TierPrice::yearly()->pluck('stripe_id')->all();

        $lines = $data['lines']['data'] ?? [];
        $isYearly = collect($lines)->contains(
            fn ($line) => in_array($line['price']['id'] ?? null, $yearlyPlans)
        );

        if (! $isYearly) {
            return $this->successMethod();
        }

        UpcomingYearlyAlert::dispatch($user);

        return $this->successMethod();
    }

    /**
     * Check if a request is to cancel a user
     */
    protected function isCancelling(array $data): bool
    {
        $cancel = Arr::get($data, 'data.object.canceled_at', null);
        $previousCancel = Arr::get($data, 'data.previous_attributes.canceled_at', null);

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
