<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property boolean $is_private
 */
class CampaignRole extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\CampaignRoleUser', 'campaign_role_id');
        //return $this->belongsToMany('App\User', 'campaign_role_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'campaign_role_id');
    }

    public function savePermissions($permissions = array())
    {
        // Load existing
        $existing = [];
        foreach ($this->permissions as $permission) {
            $existing[$permission->key] = $permission;
        }

        // Loop on submitted form
        foreach ($permissions as $key => $value) {
            // Check if exists
            if (isset($existing[$key])) {
                // Do nothing
                unset($existing[$key]);
            } else {
                $permission = CampaignPermission::create([
                    'key' => $key,
                    'campaign_role_id' => $this->id,
                    'table_name' => $value
                ]);
            }
        }

        // Delete existing that weren't updated
        foreach ($existing as $permission) {
            $permission->delete();
        }
    }
}
