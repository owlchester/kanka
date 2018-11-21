<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class MenuLink extends MiscModel
{
    /**
     * @var string
     */
    public $table = 'menu_links';

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'entity_id',
        'name',
        'icon',
        'tab',
        'filters',
        'is_private',
    ];

    /**
     *
     */
    use VisibleTrait;
    use CampaignTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        $prefix = 'tab_';
        if (!empty($this->tab)) {
            return [
                $this->entity->child->id,
                // remove tab_ from the beginning of the string, if it's present
                '#tab_' . (substr($this->tab, 0, strlen($prefix)) == $prefix ?
                    substr($this->tab, strlen($prefix)) : $this->tab)
            ];
        }

        return $this->entity->child->id;
    }
}
