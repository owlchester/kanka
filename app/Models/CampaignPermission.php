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
        return $this->belongsTi('App\User', 'user_id');
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
        return $segments[count($segments)-2];
    }
}
