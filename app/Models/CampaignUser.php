<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SortableTrait;
use App\Observers\CampaignUserObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignUser
 *
 * @property int $id
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property Carbon $created_at
 *
 * @method static Builder|self campaignUser(int $campaignID, int $userID)
 */
class CampaignUser extends Pivot
{
    use HasUser;
    use Paginatable;
    use SortableTrait;

    public $table = 'campaign_user';

    protected array $sortable = ['user.name', 'created_at', 'last_login'];

    protected $fillable = ['user_id', 'campaign_id'];

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(CampaignUserObserver::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * Get the user's roles
     */
    public function roles(): HasManyThrough
    {
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
     */
    public function isAdmin(): bool
    {
        return $this->roles()->where(['is_admin' => true])->count() > 0;
    }

    public function scopeSearch(Builder $builder, ?string $search = null): Builder
    {
        return $builder
            ->select($this->getTable() . '.*')
            ->leftJoin('users as u', 'u.id', $this->getTable() . '.user_id')
            ->where('u.name', 'like', "%{$search}%");
    }

    /**
     * Only get users of a campaign who aren't admins (used for the bulk permission UI)
     */
    public function scopeWithoutAdmins(Builder $builder): Builder
    {
        return $builder
            ->distinct()
            ->select($this->getTable() . '.*')
            ->leftJoin('campaign_role_users as cru', 'cru.user_id', $this->getTable() . '.user_id')
            ->leftJoin('campaign_roles as cr', function ($on) {
                $on->on('cr.id', 'cru.campaign_role_id')
                    ->whereRaw('cr.campaign_id = ' . $this->getTable() . '.campaign_id');
            })
            // ->whereRaw('cr.campaign_id = ' . $this->getTable() . '.campaign_id')
            ->where(function ($sub) {
                $sub->where('is_admin', false)
                    ->orWhereNull('is_admin');
            });
    }

    public function scopeCampaignUser(Builder $builder, int $campaignID, int $userID): Builder
    {
        return $builder
            ->where('campaign_id', $campaignID)
            ->where('user_id', $userID);
    }
}
