<?php

namespace App\Models\Relations;

use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignSubmission;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\Plugin;
use App\Models\Referral;
use App\Models\Role;
use App\Models\UserApp;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait UserRelations
 * @package App\Models\Relations
 *
 * @property Collection|CampaignBoost[] $boosts
 * @property Collection|CampaignRole[] $campaignRoles
 * @property Collection|Campaign[] $campaigns
 * @property Collection|Campaign[] $following
 * @property Campaign|null $lastCampaign
 * @property Referral|null $referrer
 * @property Collection|CampaignSubmission[] $submissions
 * @property Collection|Entity[] $entities
 * @property Collection|Plugin[] $plugins
 * @property Collection|UserApp[] $apps
 * @property Collection|Role[] $roles
 * @property Collection|CampaignPermission[] $permissions
 */
trait UserRelations
{
    /**
     * Last campaign the user switched to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastCampaign()
    {
        return $this->belongsTo(Campaign::class, 'last_campaign_id', 'id');
    }

    /**
     * Get a list of campaigns the user is in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user')
            ->using('App\Models\CampaignUser');
    }

    /**
     * @return mixed
     */
    public function following()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_followers')
            ->using('App\Models\CampaignFollower');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function campaignRoles()
    {
        return $this->hasManyThrough(
            'App\Models\CampaignRole',
            'App\Models\CampaignRoleUser',
            'user_id',
            'id',
            'id',
            'campaign_role_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaignRoleUser()
    {
        return $this->hasMany('App\Models\CampaignRoleUser');
    }

    /**
     * List of boosts the user is giving
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boosts()
    {
        return $this->hasMany('App\Models\CampaignBoost', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(UserApp::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany('App\Models\CampaignSubmission');
    }

    /**
     * @return mixed
     */
    public function entities()
    {
        return $this->belongsToMany(Entity::class)
            ->using(EntityUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plugins()
    {
        return $this->hasMany(Plugin::class, 'created_by');
    }

    /**
     * Return alternative User Roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
}
