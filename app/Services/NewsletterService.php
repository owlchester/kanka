<?php

namespace App\Services;

use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Exception;
use MailerLite\MailerLite;

class NewsletterService
{
    use UserAware;

    public string $email;

    public int $userID;

    protected mixed $mailerlite;

    protected Exception $error;

    public function __construct()
    {
        $key = (string) config('mailerlite.api_key');
        $this->mailerlite = new MailerLite(['api_key' => $key]);
    }

    /**
     * @return $this
     */
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
        if (!$this->isSubscribed()) {
            return false;
        }
        $this->mailerlite->subscribers->delete($this->userID);
        return true;
    }

    /**
     */
    public function update(array $options): bool
    {
        try {
            // Build the interests of the user
            $interests = [];
            if (Arr::has($options, 'releases')) {
                $interests[] = config('mailerlite.groups.all');
                if ($this->user && $this->user->isSubscriber()) {
                    $interests[] = config('mailerlite.groups.subs');
                }
            }

            $email = $this->user?->email ?? $this->email;

            $data = [
                'email' => $email,
                'fields' => [
                    'name' => $this->user?->name
                ],
                'groups' => $interests
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
}
