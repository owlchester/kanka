<?php

namespace App;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Campaign extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'locale', 'description', 'image', 'join_token'
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'campaign_user');
    }

    /**
     * @return mixed
     */
    public function setting()
    {
        return $this->belongsTo('App\Models\CampaignSetting', 'id', 'campaign_id');
    }

    /**
     * @return mixed
     */
    public function members()
    {
        return $this->hasMany('App\CampaignUser');
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->hasMany('App\Models\CampaignRole');
    }

    /**
     * Helper function to know if a campaign has permissions. This is true as soon as the campaign has several roles
     * @return bool
     */
    public function hasPermissions()
    {
        return $this->roles()->count() > 1;
    }

    /**
     * @return array
     */
    public function membersList()
    {
        $members = [];

        foreach ($this->members()->with('user')->get() as $m) {
            $members[$m->user->id] = $m->user->name;
        }

        return $members;
    }

    /**
     * @return mixed
     */
    public function invites()
    {
        return $this->hasMany('App\Models\CampaignInvite');
    }

    /**
     * @return mixed
     */
    public function unusedInvites()
    {
        return $this->invites()->where('is_active', true);
    }

    /**
     * @return bool
     */
    public function owner()
    {
        return $this->owners()->where('user_id', Auth::user()->id)->count() == 1;
    }

    /**
     * List of owners
     * @return mixed
     */
    public function owners()
    {
        return $this->members()->where('role', 'owner');
    }

    /**
     * @return bool
     */
    public function member()
    {
        return $this->members()
                ->where('role', 'member')
                ->where('user_id', Auth::user()->id)
                ->count() == 1;
    }

    /**
     * @return bool
     */
    public function user()
    {
        return $this->members()
            ->where('user_id', Auth::user()->id)
            ->count() == 1;
    }

    /**
     * @return int
     */
    public function role()
    {
        $member = $this->members()
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($member) {
            return $member->role;
        }
        return 0;
    }

    /**
     * Determine if a campaign has an entity enabled or not
     *
     * @param $entity
     * @return bool
     */
    public function enabled($entity)
    {
        if ($this->setting->$entity) {
            return $this->setting->$entity;
        }
        return false;
    }

    /**
     * Check if a user has access to a resource
     * @param string $permission
     * @param Model $entity
     * @return bool
     */
    public function can($action = '', Model $entity)
    {
        // This is split in two parts. We look if the user is part of a is_admin role, or of a role that has the permission
        /*
         * Select * from campaign_roles as r
         * where r.campaign_id = $1
         */
    }
}
