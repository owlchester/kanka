<?php

namespace App\Models;

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
 * @property Collection|CampaignPermission[] $permissions
 * @property Collection|CampaignDashboardRole[] $dashboardRoles
 */
class CampaignRole extends Model
{
    use Paginatable;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'is_admin',
        'is_public',
        'name',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
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
     * @param $query
     * @param int $value
     * @return mixed
     */
    public function scopePublic($query, $value = 1)
    {
        return $query->where('is_public', $value);
    }

    /**
     * Get all roles except admin
     * @param $query
     * @return mixed
     */
    public function scopeWithoutAdmin($query)
    {
        return $query->where('is_admin', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'campaign_role_id');
    }

    /**
     * @param array $permissions
     */
    public function savePermissions(array $permissions = [])
    {
        // Load existing
        $existing = [];
        foreach ($this->permissions as $permission) {
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

                $this->add($module, $action);
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
    public function scopeSearch(Builder $builder, string $search = null)
    {
        return $builder
            ->where('name', 'like', "%$search%");
    }

    /**
     * Toggle an entity's action permission
     * @param int $entityType
     * @param int $action
     * @return void
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
}
