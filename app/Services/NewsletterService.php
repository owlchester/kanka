<?php

namespace App\Services;

use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Exception;

class NewsletterService
{
    use UserAware;

    /** @var string interest-ids */
    public string $releaseID = '3cbff83812';

    /** @var string List name */
    public string $listName = 'subscribers';

    /** @var string */
    public string $email;

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
        return Newsletter::isSubscribed($this->user->email);
    }

    /**
     * Unsubscribe a user
     */
    public function remove()
    {
        return Newsletter::unsubscribe($this->user->email, $this->listName);
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
                $interests[$this->releaseID] = Arr::get($options, 'releases');
            }

            $res = Newsletter::subscribeOrUpdate(
                $this->user ? $this->user->email : $this->email,
                $this->user ? ['FNAME' => $this->user->name, 'LNAME' => ''] : [],
                $this->listName,
                [
                    'interests' => $interests
                ]
            );

            if (!empty($res)) {
                return true;
            }

            // Log error?
            $error = Newsletter::getLastError();
            Log::warning($error);

            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
