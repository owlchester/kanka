<?php


namespace App\Services\Caches;


use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserCacheService extends BaseCache
{
    /** @var User */
    protected $user;

    /**
     * UserCacheService constructor.
     */
    public function __construct()
    {
        $this->user = Auth::check() ? Auth::user() : null;
        parent::__construct();
    }

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
     * Check if a user is an admin of a campaign
     * @return bool
     */
    public function admin(): bool
    {
        return $this->roles()
            ->where('campaign_id', $this->campaign->id)
            ->where('is_admin', true)
            ->count() === 1;
    }

    /**
     * Get the user campaigns
     * @return Collection
     */
    public function campaigns(): Collection
    {
        $key = $this->campaignsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->user->campaigns;
        $this->put($key, $data, 24 * 3600);

        return $data;
    }

    /**
     * Clear user campaign cache
     * @return $this
     */
    public function clearCampaigns(): self
    {
        $key = $this->campaignsKey();
        $this->forget($key);
        return $this;
    }

    /**
     * Get the user roles
     * @return Collection
     */
    public function roles(): Collection
    {
        $key = $this->rolesKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->user->campaignRoles;
        $this->put($key, $data, 24 * 3600);

        return $data;
    }

    /**
     * Clear user roles cache
     * @return $this
     */
    public function clearRoles(): self
    {
        $key = $this->rolesKey();
        $this->forget($key);
        return $this;
    }

    /**
     * Get the user follows
     * @return Collection
     */
    public function follows(): Collection
    {
        $key = $this->followsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->user->following;
        $this->put($key, $data, 24 * 3600);

        return $data;
    }

    /**
     * Clear user campaign cache
     * @return $this
     */
    public function clearFollows(): self
    {
        $key = $this->followsKey();
        $this->forget($key);
        return $this;
    }

    /**
     * @return string
     */
    protected function rolesKey(): string
    {
        return 'user_' . $this->user->id . '_roles';
    }

    /**
     * @return string
     */
    protected function campaignsKey(): string
    {
        return 'user_' . $this->user->id . '_campaigns';
    }

    /**
     * @return string
     */
    protected function followsKey(): string
    {
        return 'user_' . $this->user->id . '_follows';
    }
}
