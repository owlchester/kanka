<?php


namespace App\Http\Controllers;


use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\SubscriptionSource;
use App\Notifications\Header;
use App\Services\SubscriptionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController  extends CashierController
{
    /**
     * Handle an updated subscription (for example when managing 3d secure payments)
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        // Call parent handler method
        $response = parent::handleCustomerSubscriptionUpdated($payload);

        // User setup
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            /** @var SubscriptionService $service */
            $service = app()->make('App\Services\SubscriptionService');

            $data = $payload['data']['object'];
            $status = Arr::get($data, 'status', false);
            // If the status is past_due, we need to remind the user to update their credit card info
            if ($status != 'past_due') {
                $service->user($user)->webhook()->finish($payload['data']['object']['plan']['id']);
            }
        }
        return $response;
    }

    /**
     * Handle a deleted subscription
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        // Call parent handler method
        $response = parent::handleCustomerSubscriptionDeleted($payload);

        // User notification. Maybe even an email
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {

            // Notify admin
            SubscriptionDeletedEmailJob::dispatch($user);

            // Set the subscription to end when it's supposed to end (admittedly, this is already passed)
            SubscriptionEndJob::dispatch($user)->delay(
                $user->subscription('kanka')->ends_at
            );
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
        Log::warning('succeeded charge', $payload);
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $charge = $payload['data']['object']['charge'];

            $source = SubscriptionSource::where(['user_id' => $user->id, 'charge_id', $charge])->first();
            if ($source) {

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
            /** @var SubscriptionService $subscription */
            $subscription = app()->make(SubscriptionService::class);
            $subscription
                ->user($user)
                ->webhook()
                ->chargeFailed($payload);
        }
        return $this->successMethod();

    }
}
