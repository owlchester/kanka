<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Str;

/**
 * Class CampaignPermission
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $campaign_role_id
 * @property integer $user_id
 * @property string $key
 * @property string $table_name
 * @property bool $access
 */
class CampaignPermission extends Model
{
    /**
     * @var bool|array
     */
    protected $cachedSegments = false;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_role_id',
        'key',
        'table_name',
        'user_id',
        'entity_id',
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

        // Todo: move this info somewhere else so we can avoid a massive split
        if (Str::startsWith($this->key, 'attribute_template')) {
            $segments[0] = 'attribute_template';
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
}
