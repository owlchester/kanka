<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class CampaignPermission
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $campaign_role_id
 * @property integer $user_id
 * @property string $key
 * @property string $table_name
 */
class CampaignPermission extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_role_id',
        'key',
        'table_name',
        'user_id',
        'entity_id',
    ];

    /**
     * Optional campaign role
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
        $segments = explode('_', $this->key);
        return $segments[count($segments)-1];
    }

    /**
     * @return mixed
     */
    public function action()
    {
        $segments = explode('_', $this->key);
        return $segments[count($segments)-(empty($this->entity_id) ? 1 : 2)];
    }

    /**
     * Determine if a permission targets an entity by checking the last part of the segment
     * @return bool
     */
    public function targetsEntity()
    {
        $segments = explode('_', $this->key);
        return is_numeric($segments[count($segments)-1]);
    }
}
