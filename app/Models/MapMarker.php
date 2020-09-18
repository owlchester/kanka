<?php


namespace App\Models;


use App\Facades\Mentions;
use App\Models\Concerns\Paginatable;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class MapMarker
 * @package App\Models
 *
 * @property Map $map
 * @property Entity $entity
 * @property int $id
 * @property int $map_id
 * @property int $entity_id
 * @property string $name
 * @property string $entry
 * @property int $longitude
 * @property int $latitude
 * @property string $colour
 * @property string $font_colour
 * @property int $shape_id
 * @property int $size_id
 * @property int $icon
 * @property string $custom_icon
 * @property string $custom_shape
 * @property bool $is_draggable
 * @property float $opacity
 * @property string $visibility
 * @property int $group_id
 * @property MapGroup $group
 */
class MapMarker extends Model
{
    use VisibilityTrait, Paginatable;

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
        'font_colour',
        'longitude',
        'latitude',
        'opacity',
        'group_id',
    ];

    /** @var bool Editing the map */
    protected $editing = false;

    /** @var bool Exploring the map */
    protected $exploring = false;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(MapGroup::class, 'group_id');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        if (!empty($this->custom_icon)) {
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
                title: \'' . $this->markerTitle() . '\',
                stroke: false,
                fillOpacity: ' . $this->opacity() . ',
                className: \'marker marker-circle marker-' . $this->id . ' size-' . $this->size_id . '\','
                . ($this->isDraggable() ? 'draggable: true' : null) . '
            })' . $this->popup();

        }
        elseif ($this->shape_id == MapMarker::SHAPE_LABEL) {
            return 'L.marker([' . ($this->latitude ). ', ' . $this->longitude . '], {
                opacity: 0,
                icon: labelShapeIcon,'
                . ($this->editing ? 'draggable: true' : null) . '
            }).bindTooltip(`' . $this->name . '`, {
                direction: \'center\',
                permanent: true,
                offset: [0,0]
            })' . $this->popup();
        } elseif ($this->shape_id == MapMarker::SHAPE_POLY && !empty($this->custom_shape)) {
            $coords = [];
            $segments = explode(' ', str_replace("\r\n", " ", $this->custom_shape));
            foreach ($segments as $segment) {
                $coord = explode(',', $segment);
                if (!empty($coord) && !empty($coord[0]) && !empty($coord[1])) {
                    $coords[] = '[' . $coord[0] . ', ' . Str::before($coord[1], ' ') . ']';
                }
            }
            // ' . implode(', ', $coords) . '
            return 'L.polygon([' . implode(', ', $coords) . '], {
                color: \'' . e($this->colour) . '\',
                weight: 1,
                opacity: ' . $this->opacity() . ',
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\',
            })' . $this->popup();
        }

        return 'L.marker([' . ($this->latitude ). ', ' . $this->longitude . '], {
            title: \'' . $this->markerTitle() . '\',
            opacity: ' . $this->opacity() . ','
            . ($this->isDraggable() ? 'draggable: true,' : null) . '
            ' . $this->markerIcon() . '
        })' . $this->popup() . $this->draggable();
    }

    /**
     * @return string
     */
    protected function popup(): string
    {
        if ($this->editing) {
            return '';
        }

        $body = null;
        if (!empty($this->entity)) {
            if (!empty($this->name)) { // Name is set, include link to the entity
                $url = $this->entity->url();
                $body .= "<p><a href=\"$url\">" . $this->entity->name . "</a></p>";
            }
            // No entry field, include the entity tooltip
            if ($this->shape_id != MapMarker::SHAPE_LABEL) {
                $body .= $this->entity->mappedPreview();
            }
        }
        if ($this->exploring) {
            return '.bindPopup(`
            <div class="marker-popup-content">
                <h4 class="marker-header">' . str_replace('`', '\'', $this->markerTitle(true)) . '</h4>
                ' . ($this->shape_id == MapMarker::SHAPE_LABEL ? '<p class="marker-text">' . Mentions::mapAny($this) . '</p>' : null) . '
            </div>
            ' . $body . '`)
            .on(`mouseover`, function (ev) {
                this.openPopup();
            })
            .on(`click`, function (ev) {
                window.markerDetails(`' . route('maps.markers.details', [$this->map_id, $this->id]) . '`)
            })';
        }

        return '.bindPopup(`
            <div class="marker-popup-content">
                <h4 class="marker-header">' . str_replace('`', '\'', $this->markerTitle(true)) . '</h4>
                ' . ($this->shape_id == MapMarker::SHAPE_LABEL ? '<p class="marker-text">' . Mentions::mapAny($this) . '</p>' : null) . '
            </div>
            ' . $body . '
            <div class="marker-popup-actions">
                <a href="' . route('maps.map_markers.edit', [$this->map_id, $this->id]). '" class="btn btn-xs btn-primary">' . __('crud.edit') . '</a>

                <a href="#" class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="'. e($this->name) .'"
                        data-target="#delete-confirm" data-delete-target="delete-form-marker-' . $this->id . '"
                        title="' . __('crud.remove') . '">
                    ' . __('crud.remove') . '
                </a>
            </div>`
        )';
    }

    /**
     * Determin if a marker is draggable
     * @return bool
     */
    protected function isDraggable(): bool
    {
        return $this->editing || ($this->exploring && $this->is_draggable);
    }

    /**
     * @return string
     */
    protected function draggable(): string
    {
        if (!$this->isDraggable()) {
            return '';
        }

        // Exploring and moving? Update through ajax
        if ($this->exploring && $this->is_draggable) {
            return '.on(`dragstart`, function() {
                this.closePopup();
            })

            .on(\'dragend\', function() {
                var coordinates = marker' . $this->id . '.getLatLng();
                console.log(`dragend`, coordinates);
                $.ajax({
                    url: `' . route('maps.markers.move', [$this->map_id, $this->id]) . '`,
                    type: `post`,
                    data: {latitude: coordinates.lat.toFixed(3), longitude: coordinates.lng.toFixed(3)}
                }).done(function (data) {
                    console.log(`moved marker`);
                });
            })';
        }

        return '.on(\'dragend\', function() {
            var coordinates = marker' . $this->id . '.getLatLng();
            console.log(\'coords\', coordinates);
            console.log(\'new coords\', coordinates.lat, coordinates.lng);

            var shapeId = $(\'input[name="shape_id"]\').val();
            var polyCoords = $(\'textarea[name="custom_shape"]\');
            console.log(\'shape id\', shapeId);
            if (shapeId == "5") {
                console.log(\'poly\', polyCoords.val());
                polyCoords.val(polyCoords.val() + \' \' + coordinates.lat.toFixed(3) + \',\' + coordinates.lng.toFixed(3));
            } else {
                $(\'#marker-latitude\').val(coordinates.lat.toFixed(3));
                $(\'#marker-longitude\').val(coordinates.lng.toFixed(3));
            }
        })';
    }

    /**
     * Marker icon as shown in explore and edit mode
     * @return string
     */
    protected function markerIcon(): string
    {
        if ($this->icon == 5) {
            return '';
        }

        $iconStyles = [];
        $iconStyles[] = 'background-color: ' . $this->backgroundColour();
        if ($this->entity && $this->icon == 4) {
            $entityImage = '<div class="marker-entity" style="background-image: url(' . $this->entity->child->getImageUrl(400) . ');"></div>';
        }

        $iconShape = '<div style="background-color: ' . $this->backgroundColour() . '" class="marker-pin"></div>';

        $icon = '`' . $iconShape . '<i class="fa fa-pin-marker"></i>`';
        if (!empty($this->custom_icon)) {
            if (Str::startsWith($this->custom_icon, '<i')) {
                $icon = '`' . $iconShape . '' . $this->custom_icon . '`';
            } elseif(Str::startsWith($this->custom_icon, '<?xml')) {
                $icon = 'L.Util.template(`<div class="custom-icon">' . $this->resizedCustomIcon() . '</div>`)';
            }
        }
        elseif ($this->icon == 2) {
            $icon = '`' . $iconShape . '<i class="fa fa-question"></i>`';
        } elseif ($this->icon == 3) {
            $icon = '`' . $iconShape . '<i class="fa fa-exclamation"></i>`';
        }

        return 'icon: L.divIcon({
                html: ' . $icon . ',
                iconSize: [40, 40],
                iconAnchor: [20, 50],
                popupAnchor: [0, -50],
                className: \'marker marker-' . $this->id . '\'
        })';

    }

    /**
     * The name of the marker: name or entity
     * @param bool $link = false
     * @return string
     */
    public function markerTitle(bool $link = false): string
    {
        if (empty($this->name) && !empty($this->entity)) {
            if ($link) {
                return '<a href="' . $this->entity->url() . '">' . e($this->entity->name) . '</a>';
            }
            return e($this->entity->name);
        }
        return e($this->name);
    }

    /**
     * @return $this
     */
    public function editing(): self
    {
        $this->editing = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function exploring(): self
    {
        $this->exploring = true;
        return $this;
    }

    /**
     * Get the opacity of a point. Users input a %, convert it to a float for leaflet
     * @return float
     */
    protected function opacity(): float
    {
        if (empty($this->opacity) || $this->opacity > 100) {
            return 1.0;
        }

        return round($this->opacity / 100, 1);
    }

    /**
     * Resize any custom svg icon to be limited in height and width to the pin
     * @return string
     */
    protected function resizedCustomIcon(): string
    {
        $resized = preg_replace('`(width|height)=\".*?\"`sui', '$1="32"', $this->custom_icon);
        $resized = str_replace('height="32"', 'height="32" style="margin-top: 4px;"', $resized);
        return $resized;
    }

    /**
     * Marker background colour
     * @return string
     */
    public function backgroundColour(): string
    {
        if (!empty($this->colour)) {
            return $this->colour;
        }

        // Entity with no image?
        if ($this->icon == 4 && empty($this->entity->child->image)) {
            return '#ccc';
        }

        if ($this->icon != 1 || !empty($this->custom_icon)) {
            return 'unset';
        }
        return '#ccc';
    }

    /**
     * Check if a marker is visible (pointing to an entity that shouldn't be visible)
     * @return bool
     */
    public function visible(): bool
    {
        return empty($this->entity_id) || (!empty($this->entity) && !empty($this->entity->child));
    }
}
