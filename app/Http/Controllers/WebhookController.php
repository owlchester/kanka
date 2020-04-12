<?php


namespace App\Http\Controllers;


use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Mail\Subscription\Admin\FailedSubscriptionMail;
use App\Mail\Subscription\Admin\NewSubscriptionMail;
use App\Mail\WelcomeEmail;
use App\Notifications\Header;
use App\Services\SubscriptionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

            //Log::info(Arr::get($payload, 'data.object.plan'));
            $service->user($user)->finish($payload['data']['object']['plan']['id']);
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
            $user->notify(new Header(
                'subscriptions.notifications.failed',
                'far fa-credit-card',
                'red'
            ));

            // Notify admin
            SubscriptionFailedEmailJob::dispatch($user);

            // Set the subscription to end when it's supposed to end (admittedly, this is already passed)
            SubscriptionEndJob::dispatch($user)->delay(
                $user->subscription('kanka')->ends_at
            );
        }

        return $response;
    }
}
