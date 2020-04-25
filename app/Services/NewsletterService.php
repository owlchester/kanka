<?php


namespace App\Services;


use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Exception;

class NewsletterService
{
    /** @var string interest-ids */
    public $newsletterID = '2d44264f87';
    public $releaseID = '3cbff83812';
    public $voteID = 'ba589a486e';

    /** @var string List name */
    public $listName = 'subscribers';

    /** @var User */
    protected $user;

    /** @var string */
    public $email;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
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
     * @param $options
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
            if (Arr::has($options, 'newsletters')) {
                $interests[$this->newsletterID] = Arr::get($options, 'newsletters');
            }
            if (Arr::has($options, 'votes')) {
                $interests[$this->voteID] = Arr::get($options, 'votes');
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
