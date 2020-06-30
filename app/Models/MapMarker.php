<?php


namespace App\Models;


use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MapMarker
 * @package App\Models
 *
 * @property Map $map
 * @property Entity $entity
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property string $entry
 * @property int $longitude
 * @property int $latitude
 * @property string $colour
 * @property int $shape_id
 * @property int $size_id
 * @property int $icon
 * @property string $custom_icon
 * @property string $custom_shape
 * @property bool $is_draggable
 * @property string $visibility
 */
class MapMarker extends Model
{
    use VisibilityTrait;

    const SHAPE_MARKER = 1;
    const SHAPE_LABEL = 2;
    const SHAPE_CIRCLE = 3;
    const SHAPE_POLY = 5;

    /** Fillable fields */
    protected $fillable = [
        'map_id',
        'name',
        'entry',
        'visibility',
        'entity_id',
        'type_id',
        'size_id',
        'shape_id',
        'icon',
        'custom_icon',
        'custom_shape',
        'is_draggable',
        'colour',
        'longitude',
        'latitude',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        if ($this->icon == 5 && !empty($this->custom_icon)) {
            return '<i class="' . $this->custom_icon . '"></i>';
        }
        if ($this->icon == 4 && !empty($this->entity)) {
            return '<div class="entity-image" style="background-image: url(' . $this->entity->child->getImageUrl(40) . '); width: 100%; height: 100%"></div>';
        }

        switch ($this->icon) {
            case 2:
                return '<i class="fa fa-question"></i>';
            case 3:
                return '<i class="fa fa-exclamation"></i>';
            default:
                return '<i class="fa fa-marker"></i>';
        }
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return ($this->size_id * 20) + 20;
    }

    public function marker(): string
    {
        if ($this->shape_id == MapMarker::SHAPE_CIRCLE) {
            return 'L.circle([' . $this->latitude . ', ' . $this->longitude . '], {
                radius: ' . $this->size_id * 20 . ',
                fillColor: \'' . e($this->colour) . '\',
                title: \'' . $this->makerTitle() . '\',
                stroke: false,
                className: \'marker marker-' . $this->id . ' size-' . $this->size_id . '\'
            })' . $this->popup();

        }
        elseif ($this->shape_id == MapMarker::SHAPE_LABEL) {
            return 'L.marker([' . ($this->latitude ). ', ' . $this->longitude . '], {
                opacity: 0
            }).bindTooltip(`' . $this->name . '`, {
                direction: \'center\',
                permanent: true
            })' . $this->popup();
        } elseif ($this->shape_id == MapMarker::SHAPE_POLY) {
            $coords = [];
            $segments = explode(' ', $this->custom_shape);
            foreach ($segments as $segment) {
                $coord = explode(',', $segment);
                if (!empty($coord) && !empty($coord[0]) && !empty($coord[1])) {
                    $coords[] = '[' . $coord[0] . ', ' . $coord[1] . ']';
                }
            }
            return 'L.polygon([' . implode(', ', $coords) . '], {
                color: \'' . e($this->colour) . '\',
                weight: 1,
                opacity: 0.5,
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\'
            })' . $this->popup();
        }

        return 'L.marker([' . ($this->latitude ). ', ' . $this->longitude . '], {
            title: \'' . $this->makerTitle() . '\',
            ' . $this->markerIcon() . '
        })' . $this->popup();
    }

    protected function popup(): string
    {
        return '.bindPopup(`
        <div class="marker-popup-content">
            <h4 class="marker-header">' . e($this->name) . '</h4>
            <p class="marker-text">' . $this->entry . '</p>
        </div>`';
    }

    protected function markerIcon(): string
    {
        if ($this->icon == 5) {
            return '';
        }

        $icon = 'fa fa-pin-marker';
        if ($this->icon == 2) {
            $icon = 'fa fa-question';
        } elseif ($this->icon == 3) {
            $icon = 'fa fa-exclamation';
        } elseif ($this->icon == 4 && !empty($this->custom_icon)) {
            $icon = e($this->custom_icon);
        }

        return 'icon: L.divIcon({
                html: \'<i class="' . $icon . '"></i>\',
                iconSize: [40, 40],
                className: \'marker marker-' . $this->id . '\'
        })';

    }

    /**
     * @return string
     */
    protected function makerTitle(): string
    {
        if (empty($this->name) && !empty($this->entity)) {
            return e($this->entity->name);
        }
        return e($this->name);
    }
}
