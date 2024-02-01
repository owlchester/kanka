<?php

namespace App\Models\Relations;

use App\Models\BragiLog;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignSubmission;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\FeatureVote;
use App\Models\PasswordSecurity;
use App\Models\Plugin;
use App\Models\Referral;
use App\Models\Role;
use App\Models\UserApp;
use App\Models\UserFlag;
use App\Models\Users\Tutorial;
use App\Models\UserValidation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property PasswordSecurity|null $passwordSecurity
 * @property Collection|UserFlag[] $flags
 * @property Collection|Tutorial[] $tutorials
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
            ->withPivot('created_at')
            ->using('App\Models\CampaignUser');
    }

    /**
     */
    public function following()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_followers')
            ->withPivot('created_at')
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
     * @return HasMany
     */
    public function campaignRoleUser()
    {
        return $this->hasMany('App\Models\CampaignRoleUser');
    }

    /**
     * List of boosts the user is giving
     * @return HasMany
     */
    public function boosts()
    {
        return $this->hasMany('App\Models\CampaignBoost', 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function apps()
    {
        return $this->hasMany(UserApp::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
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
     * @return HasMany
     */
    public function submissions()
    {
        return $this->hasMany('App\Models\CampaignSubmission');
    }

    /**
     */
    public function entities()
    {
        return $this->belongsToMany(Entity::class)
            ->using(EntityUser::class);
    }

    /**
     * @return HasMany
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

    public function bragiLogs()
    {
        return $this->hasMany(BragiLog::class);
    }

    /**
     * List of subscription cancellations for the user
     * @return HasMany
     */
    public function cancellations()
    {
        return $this->hasMany('App\Models\SubscriptionCancellation', 'user_id', 'id');
    }

    /**
     * List of the user's flags
     */
    public function flags()
    {
        return $this->hasMany(UserFlag::class, 'user_id', 'id');
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(FeatureVote::class);
    }

    public function userValidation(): HasMany
    {
        return $this->hasOne(UserValidation::class, 'user_id', 'id');
    }
}
