<?php


namespace App\Http\Controllers;


use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Mail\Subscription\Admin\FailedSubscriptionMail;
use App\Mail\Subscription\Admin\NewSubscriptionMail;
use App\Mail\WelcomeEmail;
use App\Notifications\Header;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController  extends CashierController
{
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
