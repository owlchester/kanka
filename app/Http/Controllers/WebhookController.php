<?php

namespace App\Http\Controllers;

use App\Enums\UserAction;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Jobs\Emails\Subscriptions\WelcomeSubscriptionEmailJob;
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
     * Handle a newly created subscription. Sends emails for direct-to-active subscriptions
     * (credit card without 3D Secure). PayPal and 3DS start as incomplete and are handled
     * in handleCustomerSubscriptionUpdated once Stripe confirms them.
     */
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        $response = parent::handleCustomerSubscriptionCreated($payload);

        $data = $payload['data']['object'];
        $status = Arr::get($data, 'status');

        if ($status !== 'active') {
            return $response;
        }

        if (! $user = $this->getUserByStripeId($data['customer'] ?? null)) {
            return $response;
        }

        /** @var User $user */
        $planId = Arr::get($data, 'plan.id') ?? Arr::get($data, 'items.data.0.price.id');
        if (! $planId) {
            return $response;
        }

        /** @var SubscriptionService $service */
        $service = app()->make('App\Services\SubscriptionService');
        $service->user($user)->plan($planId)->finish();

        return $response;
    }

    /**
     * Handle an updated subscription — PayPal/3DS activations and tier upgrades send emails;
     * renewals, metadata changes, and downgrade confirmations suppress them.
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        // Call parent handler method
        $response = parent::handleCustomerSubscriptionUpdated($payload);

        if (! $user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            return $response;
        }

        /** @var User $user */
        $data = $payload['data']['object'];
        $status = Arr::get($data, 'status', false);

        Log::debug('Customer Sub Updated Status ' . $status);

        if ($status === 'past_due' || $this->isCancelling($payload)) {
            return $response;
        }

        Log::debug('Stripe payload', $payload);

        // PayPal / 3DS: subscription transitions from incomplete to active
        $previousStatus = Arr::get($payload, 'data.previous_attributes.status', null);
        $isNewActivation = $previousStatus === 'incomplete' && $status === 'active';

        // plan.id is deprecated; fall back to items for newer subscriptions
        $planId = Arr::get($data, 'plan.id') ?? Arr::get($data, 'items.data.0.price.id');
        $previousPlanId = Arr::get($payload, 'data.previous_attributes.plan.id')
            ?? Arr::get($payload, 'data.previous_attributes.items.data.0.price.id');
        $isPlanChange = $previousPlanId !== null && $previousPlanId !== $planId;

        /** @var SubscriptionService $service */
        $service = app()->make('App\Services\SubscriptionService');
        $serviceCall = $service->user($user)->plan($planId);

        if ($isNewActivation) {
            // PayPal/3DS: web controller didn't complete (IncompletePayment), so pledge
            // is still the old value. finish() can correctly determine new vs upgrade via upgrading().
            $serviceCall->finish();
        } elseif ($isPlanChange && ! $serviceCall->downgrading()) {
            // Tier upgrade confirmed by Stripe. The web controller already updated pledge
            // to the new tier, so upgrading() is unreliable here. Suppress finish()'s email
            // logic and dispatch only the user-facing welcome email (admin is not notified
            // for upgrades, matching the original behaviour).
            $serviceCall->webhook()->finish();
            if ($tierPrice = TierPrice::where('stripe_id', $planId)->first()) {
                WelcomeSubscriptionEmailJob::dispatch($user, $tierPrice->tier);
            }
        } else {
            // Renewal, downgrade confirmation, metadata change, etc.
            $serviceCall->webhook()->finish();
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
