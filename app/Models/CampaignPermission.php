<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class CampaignPermission
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $campaign_role_id
 * @property integer $campaign_id
 * @property integer $user_id
 * @property integer $entity_type_id
 * @property integer $action
 * @property string $key
 * @property string $table_name
 * @property bool $access
 * @property integer $misc_id
 *
 * @property Campaign $campaign
 * @property CampaignRole $campaignRole
 * @property Entity $entity
 * @property \App\User $user
 *
 * @method static self|Builder roleIds(array $ids)
 */
class CampaignPermission extends Model
{
    const ACTION_READ = 1;
    const ACTION_EDIT = 2;
    const ACTION_ADD = 3;
    const ACTION_DELETE = 4;
    const ACTION_POSTS = 5;
    const ACTION_PERMS = 6;

    const ACTION_MANAGE = 10;
    const ACTION_DASHBOARD = 11;
    const ACTION_MEMBERS = 12;
    const ACTION_GALLERY = 13;
    const ACTION_CAMPAIGN = 14;

    /**
     * @var bool|array
     */
    protected $cachedSegments = false;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_role_id',
        'campaign_id',
        'user_id',
        //'key',
        'action',
        //'table_name',
        'entity_id',
        'entity_type_id',
        'misc_id',
        'access',
    ];

    /**
     * Optional campaign role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaignRole()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'campaign_role_id', 'id');
    }

    /**
     * Optional user
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Optional entity
     * @return mixed
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @param $query
     * @param array $roleIds
     * @return mixed
     */
    public function scopeRoleIDs(Builder $query, array $roleIds)
    {
        return $query->whereIn('campaign_role_id', $roleIds);
    }

    /**
     * Get the entity id
     * @return mixed
     */
    public function entityId()
    {
        $segments = $this->segments();
        return $segments[count($segments)-1];
    }

    /**
     * @return mixed
     */
    public function action()
    {
        $segments = $this->segments();
        $segment = count($segments)-(empty($this->entity_id) ? 1 : 2);
        if (!isset($segments[$segment])) {
            return null;
        }
        return $segments[$segment];
    }

    /**
     * Determine if a permission targets an entity by checking the last part of the segment
     * @return bool
     */
    public function targetsEntity()
    {
        $segments = $this->segments();
        return is_numeric($segments[count($segments)-1]);
    }

    public function type()
    {
        $segments = $this->segments();
        //dd('CPT: Error 2');

        // Todo: move this info somewhere else so we can avoid a massive split
        if (Str::startsWith($this->key, 'attribute_template')) {
            $segments[0] = 'attribute_template';
        } elseif (Str::startsWith($this->key, 'dice_roll')) {
            $segments[0] = 'dice_roll';
        }
        return $segments[0];
    }

    protected function segments(): array
    {
        if ($this->cachedSegments === false) {
            $this->cachedSegments = explode('_', $this->key);
        }
        return $this->cachedSegments;
    }

    /**
     * Copy an entity inventory to another target
     * @param Entity $target
     */
    public function copyTo(Entity $target, string $from, string $to)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        $new->key = Str::replaceLast('_' . $from, '_' . $to, $new->key);
        return $new->save();
    }

    /**
     * Determine if the permission's action is the wanted one
     * @param int $action
     * @return bool
     */
    public function isAction(int $action): bool
    {
        return $this->action === $action;
    }

    /**
     * Get the "key" of the permission, used for caching and lookup in the permission engines
     * @return string
     */
    public function key(): string
    {
        // Campaign actions have a different cache key
        if ($this->action >= 10) {
            return 'campaign_' . $this->action;
        }

        // If there is no entity attached,
        if (!$this->misc_id) {
            return $this->entity_type_id . '_' . $this->action;
        }
        return '_' . $this->action . '_' . $this->misc_id;
    }

    /**
     * Check if the key is invalid (old corrupt data)
     * @return bool
     */
    public function invalidKey(): bool
    {
        // If we have an entity id, assume we are valid and end early
        if (!empty($this->entity_id)) {
            return false;
        }
        $segments = $this->segments();
        $end = last($segments);
        return is_numeric($end) && empty($this->entity_id);
    }
}
