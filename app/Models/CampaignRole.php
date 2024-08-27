<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $name
 * @property bool|int $is_admin
 * @property bool|int $is_public
 * @property Campaign $campaign
 * @property Collection|CampaignPermission[] $permissions
 * @property Collection|CampaignPermission[] $rolePermissions
 * @property Collection|CampaignDashboardRole[] $dashboardRoles
 * @property Collection|CampaignRoleUser[] $users
 *
 * @method static self|Builder admin(bool $with)
 * @method static self|Builder public(bool $with)
 * @method static self|Builder withoutAdmin()
 */
class CampaignRole extends Model
{
    use Paginatable;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'is_admin',
        'is_public',
        'name',
    ];
    /**
     * @var array
     */
    public $sortable = [
        'name',
        'is_admin',
    ];
    /**
     * Determine if the campaign role is the campaign's public role
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * Determine if the campaign role is the campaign's admin role
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany('App\Models\CampaignRoleUser', 'campaign_role_id');
    }

    public function dashboardRoles(): HasMany
    {
        return $this->hasMany(CampaignDashboardRole::class, 'campaign_role_id', 'id');
    }

    /**
     * Filter on a campaign role's public status
     */
    public function scopePublic(Builder $query, int $value = 1): Builder
    {
        return $query->where('is_public', $value);
    }

    /**
     * Get all roles except admin
     */
    public function scopeWithoutAdmin(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->admin(false);
    }

    /**
     * Get the admin role
     */
    public function scopeAdmin(Builder $query, bool $with = true): Builder
    {
        return $query->where('is_admin', $with);
    }

    /**
     */
    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'campaign_role_id');
    }

    /**
     * @return HasMany
     */
    public function rolePermissions()
    {
        return $this->permissions()
            ->whereNull('entity_id');
    }

    /**
     */
    public function scopeSearch(Builder $builder, ?string $search = null): Builder
    {
        return $builder
            ->where('name', 'like', "%{$search}%");
    }

    /**
     */
    public function url(string $sub): string
    {
        return 'campaign_roles.' . $sub;
    }

    public function duplicate(CampaignRole $campaignRole): self
    {
        foreach ($this->permissions as $permission) {
            $newPermission = $permission->replicate(['campaign_role_id']);
            $newPermission->campaign_role_id = $campaignRole->id;
            $newPermission->save();
        }
        return $this;
    }
}
