<?php

namespace App\Services;

use App\User;
use Patreon\API;
use Patreon\OAuth;
use Exception;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Role;

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
     * @param $code
     * @throws Exception
     */
    public function link($code)
    {
        if (empty($code)) {
            throw new Exception('missing_code');
        }

        $clientId = config('patreon.client_id');
        $clientSecret = config('patreon.client_secret');
        $redirectUri = url('/settings/patreon-callback');

        $oauth = new OAuth($clientId, $clientSecret);
        $tokens = $oauth->get_tokens($code, $redirectUri);

        if (empty($tokens['access_token'])) {
            throw new Exception('invalid_token');
        }

        $api = new API($tokens['access_token']);
        $patreon = $api->fetch_user();
        $patron = $patreon->get('data');

        if ($patron->has('relationships.pledges')) {
            // Some pledge object that doesn't provide exact details
            $pledge = $patron->relationship('pledges')->get(0)->resolve($patreon);

            // This value is useless, probably.
            $this->user->pledge = $pledge->get('id');

            $this->user->patreonEmail = $patron->attribute('email');
            $this->user->patreonFullname = $patron->attribute('full_name');
            // Lowest tier is owlbear, elementals get a manual switch
            $this->user->patreon_pledge = 'Owlbear';
            $this->user->update(['settings', 'patreon_pledge']);

            // We're so far, good. Let's add the user to the Patreon group
            if ($pledge && !$this->user->hasRole($this->patreonRoleName)) {
                $this->user->roles()->attach($this->getRole()->id);
            }

            return true;
        }

        throw new Exception('no_pledge');
    }

    /**
     * @return mixed
     */
    protected function getRole()
    {
        return Voyager::model('Role')->where('name', '=', $this->patreonRoleName)->first();
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
     * @return array
     */
    public function patrons()
    {
        $patrons = [
            'Elemental' => [],
            'Owlbear' =>  [],
            'Goblin' => [],
            'Kobold' => []
        ];

        // We need to do this workaround since role->users() returns the TCG\User group, which doesn't have
        // our accessors for the patreon data.
        $role = Role::where(['name' => 'patreon'])->first();

        // No patreon role? Local instance or not properly set up. Let's just avoid throwing an error.
        if (empty($role)) {
            return $patrons;
        }

        $ids = $role->users()->pluck('id');
        $users = User::whereIn('id', $ids)->orderBy('name', 'ASC')->get();
        foreach ($users as $user) {
            $patrons[$user->patreon_pledge ?: 'Kobold'][] = $user;
        }

        return $patrons;
    }
}
