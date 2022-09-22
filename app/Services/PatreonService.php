<?php

namespace App\Services;

use App\User;
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
    protected User $user;

    /**
     * @var string
     */
    protected string $patreonRoleName = 'patreon';

    /**
     * Set the user
     * @param User $user
     * @return $this
     */
    public function user(User $user)
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
     * Remove a user's legacy link to the patreon service
     * @return bool
     */
    public function unlink(): bool
    {
        if (!$this->user->isLegacyPatron()) {
            return false;
        }

        if ($this->user->hasRole($this->patreonRoleName)) {
            $this->user->roles()->detach($this->getRole()->id);
        }

        $settings = $this->user->settings;
        unset($settings['patreon_fullname']);
        unset($settings['patreon_name']);
        unset($settings['patreon_id']);
        unset($settings['patreon_email']);
        if (empty($settings)) {
            $settings = null;
        }
        $this->user->pledge = null;
        $this->user->settings = $settings;
        $this->user->save();

        return true;
    }


}
