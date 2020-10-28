<?php


namespace App\Models\Relations;


use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Models\CampaignRole;
use App\Models\Referral;
use App\Models\UserApp;

/**
 * Trait UserRelations
 * @package App\Models\Relations
 *
 * @property CampaignBoost[] $boosts
 * @property CampaignRole $campaignRoles
 * @property Campaign[] $campaigns
 * @property Campaign[] $following
 * @property Campaign $lastCampaign
 * @property Referral $referrer
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
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function campaigns()
    {
        return $this->hasManyThrough(
            'App\Models\Campaign',
            'App\Models\CampaignUser',
            'user_id',
            'id',
            'id',
            'campaign_id'
        );
    }

    /**
     * @return mixed
     */
    public function following()
    {
        return $this->hasManyThrough(
            'App\Models\Campaign',
            'App\Models\CampaignFollower',
            'user_id',
            'id',
            'id',
            'campaign_id'
        );
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
     * @deprecated User::campaignRoleUser is deprecated
     */
    public function campaignRoleUser()
    {
        return $this->hasMany('App\Models\CampaignRoleUser')
            ->where('campaign_id', $this->campaign->id);
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
}
