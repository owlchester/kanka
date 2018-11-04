<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MapPoint
 * @package App\Models
 *
 * @property integer $location_id
 * @property integer $target_id
 * @property integer $axis_x
 * @property integer $axis_y
 * @property string $colour
 * @property string $name
 */
class MapPoint extends Model
{
    public const ICON_ENTITY = 'entity';

    public $table = 'location_map_points';

    protected $fillable = [
        'location_id',
        'target_id',
        'target_entity_id',
        'axis_x',
        'axis_y',
        'colour',
        'name',
        'shape',
        'size',
        'icon',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Location', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function targetEntity()
    {
        return $this->belongsTo('App\Models\Entity', 'target_entity_id');
    }

    /**
     * @return string
     */
    public function makePin()
    {
        $marker = '<i class="' . $this->icon() . '"></i>';
        $dataUrl = route('locations.map_points.show', [$this->location, $this->id]);
        $dataUpdateUrl = route('locations.map_points.edit', [$this->location, $this->id]);
        $dataMoveUrl = route('locations.map_points.move', [$this->location, $this->id]);
        $url = $this->hasTarget() ? $this->targetEntity->child->getLink() : '#';
        $style = 'top: ' . $this->axis_y . 'px; left: ' . $this->axis_x . 'px;';
        $title = $this->hasTarget() ? $this->targetEntity->tooltipWithName() : $this->name;
        $size = $this->size == 'large' ? 100 : ($this->size == 'small' ? 25 : 50);

        if ($this->hasTarget() && $this->icon == 'entity') {
            $style .= "background-image: url('" . $this->targetEntity->child->getImageUrl(true) . "');";
            $marker = '';
        }

        return '<a id="map-point-' . $this->id . '" class="point ' . $this->size . ' ' . $this->shape . ' ' . $this->colour . '" '
            . 'style="' . $style . '" href="' . $url . '" data-url="' . $dataUrl . '" '
            . 'data-url-modal="' . $dataUpdateUrl . '" title="' . $title . '" '
            . 'data-url-move="' . $dataMoveUrl . '" '
            . 'data-toggle="tooltip" data-html="true" data-top="' . $this->axis_y . '" '
            . 'data-left="' . $this->axis_x . '" data-size="' . $size . '"'
            . '>' . $marker . '</a>';
    }

    /**
     * @return bool
     */
    public function hasTarget()
    {
        return !empty($this->target_entity_id);
    }

    /**
     * @return string
     */
    public function icon()
    {
        $icon = $this->icon;
        if ($icon == 'pin' || ($icon == self::ICON_ENTITY && !$this->hasTarget())) {
            return 'fa fa-map-marker';
        } else {
            $icons = [
//                'skull' => 'skull',
//                'book' => 'book',
//                'aura' => 'aura',
//                'tower' => 'tower',
//                'fire' => 'fire',
//                'beer' => 'beer',
//                'dragon' => 'dragon',
//                'tentacle' => 'tentacle',
//                'spades-card' => 'spades-card',
//                'anvil' => 'anvil',
//                'axe' => 'axe',
//                'shield' => 'shield',
//                'bridge' => 'bridge',
//                'campfire' => 'campfire',
                'quest' => 'wooden-sign',
                'character' => 'player',
                'sprout' => 'sprout-emblem',
            ];

            $icon = 'ra ra-';
            if (!empty($icons[$this->icon])) {
                $icon .= $icons[e($this->icon)];
            } else {
                $icon .= e($this->icon);
            }
        }

        return $icon;
    }
}
