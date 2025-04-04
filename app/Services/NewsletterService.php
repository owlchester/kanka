<?php

namespace App\Services;

use App\Models\UserLog;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;
use Laravel\Cashier\Subscription;
use MailerLite\MailerLite;

class NewsletterService
{
    use UserAware;

    public string $email;

    public int $userID;

    protected mixed $mailerlite;

    protected Exception $error;

    protected array $fields;

    public function __construct()
    {
        $key = (string) config('mailerlite.api_key');
        $this->mailerlite = new MailerLite(['api_key' => $key]);
    }

    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function email(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Check if a user is subscribed
     */
    public function isSubscribed(): bool
    {
        try {
            $email = isset($this->user) ? $this->user->email : $this->email;
            $this->userID = $this->fetch($email);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Unsubscribe a user
     */
    public function remove()
    {
        $this->mailerlite->subscribers->delete($this->userID);

        return true;
    }

    /**
     * Unsubscribe a user
     */
    public function delete()
    {
        if (! $this->isSubscribed()) {
            return false;
        }
        $this->mailerlite->subscribers->delete($this->userID);

        return true;
    }

    public function update(array $options): bool
    {
        try {
            // Build the interests of the user
            $interests = [];
            if (Arr::has($options, 'releases')) {
                $interests[] = config('mailerlite.groups.all');
                if (isset($this->user) && $this->user->isSubscriber()) {
                    $interests[] = config('mailerlite.groups.subs');
                }
                if (isset($options['new']) && $options['new']) {
                    $interests[] = config('mailerlite.groups.new');
                }
            }

            $email = $this->user->email ?? $this->email;

            $data = [
                'email' => $email,
                'fields' => $this->buildFields(),
                'groups' => $interests,
            ];
            if (empty($this->userID)) {
                $this->mailerlite->subscribers->create($data);

                return true;
            } else {
                $this->mailerlite->subscribers->update($this->userID, $data);

                return true;
            }
        } catch (Exception $e) {
            $this->error = $e;

            return false;
        }
    }

    public function error(): Exception
    {
        return $this->error;
    }

    /**
     * Get the user's id based on their email
     */
    protected function fetch(string $email): int
    {
        $response = $this->mailerlite->subscribers->find($email);

        return (int) Arr::get($response, 'body.data.id');
    }

    /**
     * Guess the user's country based on their login logs
     */
    protected function guessCountry(): ?string
    {
        if (! isset($this->user)) {
            return null;
        }
        /** @var ?UserLog $latest */
        $latest = $this->user->logs()->whereNotNull('country')->latest()->first();

        return $latest?->country;
    }

    protected function buildFields(): array
    {
        $fields = [
            'name' => $this->user->name,
            'language' => $this->user->locale ?? app()->getLocale(),
            'country' => $this->guessCountry(),
        ];
        if (! empty($this->user)) {
            /** @var ?Subscription $first */
            $first = $this->user->subscriptions->where('type', 'kanka')->last();
            /** @var ?Subscription $latest */
            $latest = $this->user->subscription('kanka');
            $fields['become_a_customer'] = $first->created_at->format('Y-m-d') ?? null;
            $fields['last_purchase'] = $latest->created_at->format('Y-m-d') ?? null;
            $fields['purchases'] = $this->user->subscriptions->where('type', 'kanka')->count();
            $fields['package'] = $this->user->subscribed('kanka') ? $this->user->pledge : null;
            $fields['last_login'] = $this->user->last_login_at->format('Y-m-d');
            // Number of logins over the past month
            $fields['recent_logins'] = $this->user->logs()->logins()->where('created_at', '>=', now()->subMonth())->count();

            // Remove abandoned cart data when they sub
            if ($this->user->isSubscriber()) {
                $fields['abandoned_cart'] = null;
                $fields['abandoned_package'] = null;
            }
        }

        if (isset($this->fields)) {
            $fields = array_merge($fields, $this->fields);
        }

        return $fields;
    }
}
