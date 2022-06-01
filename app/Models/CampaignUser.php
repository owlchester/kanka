<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CampaignUser
 * @package App\Models
 *
 * @property int $user_id
 * @property int $campaign_id
 * @property User $user
 * @property Campaign $campaign
 *
 * @method static|self campaignUser(int $campaignID, int $userID)
 */
class CampaignUser extends Pivot
{
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'campaign_user';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'campaign_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get the user's roles
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function roles()
    {
        //dd('EZ5: Roles?');
        return $this->hasManyThrough(
            'App\Models\CampaignRole',
            'App\Models\CampaignRoleUser',
            'user_id',
            'id',
            'user_id',
            'campaign_role_id'
        )
        ->where('campaign_id', $this->campaign_id);
    }

    /**
     * Determin if the user is part of an admin role
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->roles()->where(['is_admin' => true])->count() > 0;
    }

    /**
     * @param Builder $builder
     * @param string|null $search
     * @return Builder
     */
    public function scopeSearch(Builder $builder, string $search = null)
    {
        return $builder
            ->select($this->getTable() . '.*')
            ->leftJoin('users as u', 'u.id', $this->getTable() . '.user_id')
            ->where('u.name', 'like', "%$search%");
    }

    /**
     * Only get users of a campaign who aren't admins (used for the bulk permission UI)
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWithoutAdmins(Builder $builder)
    {
        return $builder
            ->distinct()
            ->select($this->getTable() . '.*')
            ->leftJoin('campaign_role_users as cru', 'cru.user_id', $this->getTable() . '.user_id')
            ->leftJoin('campaign_roles as cr', 'cr.id', 'cru.campaign_role_id')
            ->whereRaw('cr.campaign_id = ' . $this->getTable() . '.campaign_id')
            ->where(['is_admin' => false]);
    }

    /**
     * @param Builder $builder
     * @param int $campaignID
     * @param int $userID
     * @return Builder
     */
    public function scopeCampaignUser(Builder $builder, int $campaignID, int $userID)
    {
        return $builder
            ->where('campaign_id', $campaignID)
            ->where('user_id', $userID);
    }
}
