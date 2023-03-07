<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $name
 * @property boolean $is_admin
 * @property boolean $is_public
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

    /** @var string[]  */
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
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * Determine if the campaign role is the campaign's admin role
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\CampaignRoleUser', 'campaign_role_id');
        //return $this->belongsToMany('App\User', 'campaign_role_users');
    }

    /**
     * @return HasMany
     */
    public function dashboardRoles()
    {
        return $this->hasMany(CampaignDashboardRole::class, 'campaign_role_id', 'id');
    }

    /**
     * Filter on a campaign role's public status
     * @param Builder $query
     * @param int $value
     * @return Builder
     */
    public function scopePublic(Builder $query, int $value = 1): Builder
    {
        return $query->where('is_public', $value);
    }

    /**
     * Get all roles except admin
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutAdmin(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->admin(false);
    }

    /**
     * Get the admin role
     * @param Builder $query
     * @param bool $with
     * @return Builder
     */
    public function scopeAdmin(Builder $query, bool $with = true): Builder
    {
        return $query->where('is_admin', $with);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'campaign_role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolePermissions()
    {
        return $this->permissions()
            ->whereNull('entity_id');
    }

    /**
     * @param array $permissions
     */
    public function savePermissions(array $permissions = [])
    {
        // Load existing
        $existing = [];
        foreach ($this->rolePermissions as $permission) {
            if (empty($permission->entity_type_id)) {
                $existing['campaign_' . $permission->action] = $permission;
                continue;
            }
            $existing[$permission->entity_type_id . '_' . $permission->action] = $permission;
        }

        // Loop on submitted form
        if (empty($permissions)) {
            $permissions = [];
        }

        foreach ($permissions as $key => $module) {
            // Check if exists$
            if (isset($existing[$key])) {
                // Do nothing
                unset($existing[$key]);
            } else {
                $action = Str::after($key, '_');
                if ($module === 'campaign') {
                    $module = 0;
                }

                $this->add($module, (int) $action);
            }
        }

        // Delete existing that weren't updated
        foreach ($existing as $permission) {
            // Only delete if it's a "general" and not an entity specific permission
            if (!is_numeric($permission->entityId())) {
                $permission->delete();
            }
        }
    }

    /**
     * @param Builder $builder
     * @param string|null $search
     * @return Builder
     */
    public function scopeSearch(Builder $builder, string $search = null): Builder
    {
        return $builder
            ->where('name', 'like', "%{$search}%");
    }

    /**
     * Toggle an entity's action permission
     * @param int $entityType
     * @param int $action
     * @return bool
     */
    public function toggle(int $entityType, int $action): bool
    {
        $perm = $this->permissions()
            ->where('entity_type_id', $entityType)
            ->where('action', $action)
            ->first();

        if ($perm) {
            $perm->delete();
            return false;
        }

        $this->add($entityType, $action);
        return true;
    }

    /**
     * Add a campaign permission for the role
     * @param int $entityType
     * @param int $action
     * @return CampaignPermission
     */
    protected function add(int $entityType, int $action): CampaignPermission
    {
        if ($entityType === 0) {
            $entityType = null;
        }
        return CampaignPermission::create([
            //'key' => $key,
            'campaign_role_id' => $this->id,
            //'table_name' => $value,
            'access' => true,
            'action' => $action,
            'entity_type_id' => $entityType
            //'campaign_id' => $campaign->id,
        ]);
    }
    /**
     * @param string $sub
     * @return string
     */
    public function url(string $sub): string
    {
        return 'campaign_roles.' . $sub;
    }

    public function routeParams(array $options = []): array
    {
        return ['campaign' => $this->campaign_id, 'campaign_role' => $this->id];
    }
}
