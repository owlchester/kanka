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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     */
    public function lastCampaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'last_campaign_id', 'id');
    }

    /**
     * List of campaigns the user is a member of
     */
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user')
            ->withPivot('created_at')
            ->using('App\Models\CampaignUser');
    }

    /**
     * List of campaigns the user is following
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_followers')
            ->withPivot('created_at')
            ->using('App\Models\CampaignFollower');
    }

    /**
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
     */
    public function campaignRoleUser(): HasMany
    {
        return $this->hasMany('App\Models\CampaignRoleUser');
    }

    /**
     * List of boosts the user is giving
     */
    public function boosts(): HasMany
    {
        return $this->hasMany('App\Models\CampaignBoost', 'user_id', 'id');
    }

    /**
     * List of logs the user has recently done
     */
    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }

    /**
     * List of connected apps (Discord) the user has set up
     */
    public function apps(): HasMany
    {
        return $this->hasMany(UserApp::class, 'user_id', 'id');
    }

    /**
     * List of campaign permissions the user has
     */
    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'user_id');
    }

    /**
     * The referral code a user used
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }

    /**
     * List of campaign submissions the user is trying to join
     */
    public function submissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignSubmission');
    }

    /**
     * List of entities the user is currently editing
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class)
            ->using(EntityUser::class);
    }

    /**
     */
    public function plugins(): HasMany
    {
        return $this->hasMany(Plugin::class, 'created_by');
    }

    /**
     * Return alternative User Roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Logs created each time a user uses Bragi
     */
    public function bragiLogs(): HasMany
    {
        return $this->hasMany(BragiLog::class);
    }

    /**
     * List of subscription cancellations for the user
     */
    public function cancellations(): HasMany
    {
        return $this->hasMany('App\Models\SubscriptionCancellation', 'user_id', 'id');
    }

    /**
     * List of the user's flags, used to know when a user can be deleted
     */
    public function flags(): HasMany
    {
        return $this->hasMany(UserFlag::class, 'user_id', 'id');
    }

    /**
     * List of tutorials the user has completed
     */
    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    /**
     * List of ideas the user has upvoted in the roadmap
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
