<?php

namespace App\Services\Tracking;

class DatalayerService
{
    /** @var bool|string */
    protected $group = false;

    /** @var array Extra parameters to pass */
    protected $additional = [];

    /** @var bool If the user is newly created */
    protected $newAccount = false;

    /** @var bool If the user is newly registered */
    protected $newSubcriber = false;

    /**
     * @return string
     */
    public function base(): string
    {
        $data = array_merge([
            'userType' => 'visitor',
            'userGroup' => $this->userGroup(),
            'userTier' => null,
            'userSubbed' => false,
            'route' => $this->route(),
            'newAccount' => $this->newAccount ? '1' : '0',
            'newSubscriber' => $this->newSubcriber ? '1' : '0',
        ], $this->additional);

        if (auth()->check()) {
            $data['userType'] = 'registered';
            $data['userTier'] = !empty(auth()->user()->patreon_pledge) ? auth()->user()->patreon_pledge : null;
            $data['userSubbed'] = !empty(auth()->user()->patreon_pledge) ? 'true' : 'false';
        }
        return json_encode($data);
    }

    /**
     * @return string
     */
    public function userGroup(): string
    {
        if ($this->group !== false) {
            return $this->group;
        }
        // Set in session? Use that
        if (session()->has('user_group')) {
            $this->group = session()->get('user_group');
            return $this->group;
        }

        if (auth()->check()) {
            $this->group = auth()->user()->id % 2 == 0 ? 'a' : 'b';
            return $this->group;
        }

        // Unlogged user, use one from the session
        $this->group = mt_rand(0, 1) === 0 ? 'a' : 'b';
        session()->put('user_group', $this->group);
        return $this->group;
    }

    /**
     * @return bool
     */
    public function groupB(): bool
    {
        return $this->userGroup() === 'b';
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function add(string $key, $value): self
    {
        $this->additional[$key] = $value;
        return $this;
    }

    /**
     * @return string
     */
    protected function route(): string
    {
        if (empty(request()->route())) {
            return '';
        }
        return (string) request()->route()->getName();
    }

    /**
     * Set the new subscriber as true
     * @return $this
     */
    public function newSubscriber(): self
    {
        $this->newSubcriber = true;
        return $this;
    }

    /**
     * Set the new account as true
     * @return $this
     */
    public function newAccount(): self
    {
        $this->newAccount = true;
        return $this;
    }
}
