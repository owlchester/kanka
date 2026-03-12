<?php

namespace App\Models\Relations;

use App\Models\Application;
use App\Models\BragiLog;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Models\CampaignFollower;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\FeatureVote;
use App\Models\PasswordSecurity;
use App\Models\Plugin;
use App\Models\Role;
use App\Models\SubscriptionCancellation;
use App\Models\User;
use App\Models\UserApp;
use App\Models\UserFlag;
use App\Models\UserLog;
use App\Models\Users\Tutorial;
use App\Models\UserValidation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait UserRelations
 *
 * @property Collection|CampaignBoost[] $boosts
 * @property Collection|CampaignRole[] $campaignRoles
 * @property Collection|Campaign[] $campaigns
 * @property Collection|Campaign[] $following
 * @property Campaign|null $lastCampaign
 * @property ?User $referrer
 * @property Collection|Application[] $applications
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
     *
     * @return BelongsTo<Campaign, $this>
     */
    public function lastCampaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'last_campaign_id', 'id');
    }

    /**
     * List of campaigns the user is a member of
     *
     * @return BelongsToMany<
     *     Campaign,
     *     $this,
     *     CampaignUser
     * >
     */
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user')
            ->withPivot('created_at')
            ->using('App\Models\CampaignUser');
    }

    /**
     * List of campaigns the user is following
     *
     * @return BelongsToMany<
     *     Campaign,
     *     $this,
     *     CampaignFollower
     * >
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_followers')
            ->withPivot('created_at')
            ->using('App\Models\CampaignFollower');
    }

    /**
     * @return HasManyThrough<CampaignRole, CampaignRoleUser, $this>
     */
    public function campaignRoles(): HasManyThrough
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
     * List of campaign roles the user is part of
     *
     * @return HasMany<CampaignRoleUser, $this>
     */
    public function campaignRoleUser(): HasMany
    {
        return $this->hasMany('App\Models\CampaignRoleUser');
    }

    /**
     * List of boosts the user is giving
     *
     * @return HasMany<CampaignBoost, $this>
     */
    public function boosts(): HasMany
    {
        return $this->hasMany('App\Models\CampaignBoost', 'user_id', 'id');
    }

    /**
     * List of logs the user has recently done
     *
     * @return HasMany<UserLog, $this>
     */
    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }

    /**
     * List of connected apps (Discord) the user has set up
     *
     * @return HasMany<UserApp, $this>
     */
    public function apps(): HasMany
    {
        return $this->hasMany(UserApp::class, 'user_id', 'id');
    }

    /**
     * List of campaign permissions the user has
     *
     * @return HasMany<CampaignPermission, $this>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'user_id');
    }

    /**
     * The referral code a user used
     *
     * @return BelongsTo<User, $this>
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    /**
     * List of campaign applications the user is trying to join
     *
     * @return HasMany<Application, $this>
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * List of entities the user is currently editing
     *
     * @return BelongsToMany<
     *     Entity,
     *     $this,
     *     EntityUser
     * >
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class)
            ->using(EntityUser::class);
    }

    /**
     * @return HasMany<Plugin, $this>
     */
    public function plugins(): HasMany
    {
        return $this->hasMany(Plugin::class, 'created_by');
    }

    /**
     * Return alternative User Roles.
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Logs created each time a user uses Bragi
     *
     * @return HasMany<BragiLog, $this>
     */
    public function bragiLogs(): HasMany
    {
        return $this->hasMany(BragiLog::class);
    }

    /**
     * List of subscription cancellations for the user
     *
     * @return HasMany<SubscriptionCancellation, $this>
     */
    public function cancellations(): HasMany
    {
        return $this->hasMany('App\Models\SubscriptionCancellation', 'user_id', 'id');
    }

    /**
     * List of the user's flags, used to know when a user can be deleted
     *
     * @return HasMany<UserFlag, $this>
     */
    public function flags(): HasMany
    {
        return $this->hasMany(UserFlag::class, 'user_id', 'id');
    }

    /**
     * List of tutorials the user has completed
     *
     * @return HasMany<Tutorial, $this>
     */
    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    /**
     * List of ideas the user has upvoted in the roadmap
     *
     * @return HasMany<FeatureVote, $this>
     */
    public function upvotes(): HasMany
    {
        return $this->hasMany(FeatureVote::class);
    }

    /**
     * User email validation done
     */
    public function userValidation(): HasOne|UserValidation
    {
        return $this->hasOne(UserValidation::class, 'user_id', 'id');
    }
}
