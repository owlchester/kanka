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
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'campaign_role_users');
    }
}
