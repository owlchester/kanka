<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Arr;
use App\Models\Role;

/**
 * Class PatreonService
 * @package App\Services
 */
class PatreonService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $patreonRoleName = 'patreon';

    /**
     * Set the user
     * @param null $user
     * @return $this
     */
    public function user($user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getRole()
    {
        return Role::where('name', '=', $this->patreonRoleName)->first();
    }

    /**
     * Remove a user from the patreon role
     * @return bool
     */
    public function unlink(): bool
    {
        if (!$this->user->hasPatreonSync()) {
            return false;
        }

        if ($this->user->hasRole($this->patreonRoleName)) {
            $this->user->roles()->detach($this->getRole()->id);
        }

        $this->user->pledge = null;
        $this->user->patreon_email = null;
        $this->user->patreon_fullname = null;
        $this->user->patreon_pledge = null;
        $this->user->update(['settings', 'patreon_pledge']);

        return true;
    }

    /**
     * @return array|array[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function patrons(): array
    {
        $cacheKey = 'about_subscribers';
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }
        $patrons = [
            'Elemental' => [],
            'Wyvern' => [],
            'Owlbear' =>  [],
            'Goblin' => [],
            'Kobold' => []
        ];

        // We need to do this workaround since role->users() returns the TCG\User group, which doesn't have
        // our accessors for the patreon data.
        /** @var Role $role */
        $role = Role::where(['name' => 'patreon'])->first();

        // No patreon role? Local instance or not properly set up. Let's just avoid throwing an error.
        if (empty($role)) {
            return $patrons;
        }

        $ids = $role->users()->pluck('id');
        /** @var User $user */
        $users = User::select(['patreon_pledge', 'name', 'settings'])->whereIn('id', $ids)->orderBy('name', 'ASC')->get();
        foreach ($users as $user) {
            if (Arr::get($user, 'settings.hide_subscription', false)) {
                continue;
            }
            $patrons[$user->patreon_pledge ?: 'Kobold'][] = $user->name;
        }

        // Cache for a day
        cache()->set($cacheKey, $patrons, 3600 * 24);

        return $patrons;
    }
}
