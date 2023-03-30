<?php

namespace App\Services;

use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Exception;
use MailerLite\MailerLite;

class NewsletterService
{
    use UserAware;

    /** @var string interest-ids */
    public string $releaseID = '3cbff83812';

    /** @var string List name */
    public string $listName = 'subscribers';

    /** @var string */
    public string $email;

    public int $userID;

    protected mixed $mailerlite;

    public function __construct()
    {
        $key = (string) config('mailerlite.api_key');
        $this->mailerlite = new MailerLite(['api_key' => $key]);
    }

    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Check if a user is subscribed
     * @return bool
     */
    public function isSubscribed(): bool
    {
        try {
            $email = $this->user? $this->user->email : $this->email;
            $this->userID = $this->fetch($email);
            return true;
        } catch (\Exception $e) {
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
     * @param array $options
     * @return bool
     */
    public function update($options): bool
    {
        try {
            // Build the interests of the user
            $interests = [];
            if (Arr::has($options, 'releases')) {
                $interests[] = 84086713298715839;
            }

            $email = $this->user ? $this->user->email : $this->email;

            $data = [
                'email' => $email,
                    'fields' => [
                    'name' => $this->user?->name
                ],
                'groups' => $interests
            ];
            if (empty($this->userID)) {
                echo "Subbing";
                $this->mailerlite->subscribers->create($data);
                return true;
            } else {
                echo "Removing";
                $this->mailerlite->subscribers->update($this->userID, $data);
                return true;
            }

            echo 'what';

            return false;
        } catch (Exception $e) {
            throw $e;
            return false;
        }
    }

    protected function fetch(string $email): int
    {
        $response = $this->mailerlite->subscribers->find($email);
        return (int) Arr::get($response, 'body.data.id');
    }
}
