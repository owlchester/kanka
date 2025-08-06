<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\MapMarkerCache;
use App\Facades\Mentions;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Copiable;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasSuggestions;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class MapMarker
 *
 * @property Map $map
 * @property ?Entity $entity
 * @property int $id
 * @property int $map_id
 * @property ?int $entity_id
 * @property string $name
 * @property string $entry
 * @property int $longitude
 * @property int $latitude
 * @property string $colour
 * @property string $font_colour
 * @property ?int $shape_id
 * @property ?int $size_id
 * @property ?int $icon
 * @property string $custom_icon
 * @property string $custom_shape
 * @property ?int $circle_radius
 * @property bool|int $is_draggable
 * @property bool|int $is_popupless
 * @property array $polygon_style
 * @property float $opacity
 * @property ?int $group_id
 * @property ?int $pin_size
 * @property MapGroup|null $group
 */
class MapMarker extends Model
{
    use Blameable;
    use Copiable;
    use HasEntry;
    use HasFactory;
    use HasSuggestions;
    use HasVisibility;
    use Paginatable;
    use Sanitizable;
    use SortableTrait;

    public const SHAPE_MARKER = 1;

    public const SHAPE_LABEL = 2;

    public const SHAPE_CIRCLE = 3;

    public const SHAPE_POLY = 5;

    protected $fillable = [
        'map_id',
        'name',
        'entry',
        'visibility_id',
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
        'pin_size',
        'circle_radius',
        'polygon_style',
        'is_popupless',
    ];

    protected array $sortable = [
        'name',
        'entity_id',
        'type',
        'icon',
        'group.name',
        'visibility',
    ];

    public $casts = [
        'polygon_style' => 'array',
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $suggestions = [
        MapMarkerCache::class => 'clearSuggestion',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /** Editing the map */
    protected bool $editing = false;

    /** Exploring the map */
    protected bool $exploring = false;

    /** Marker MouseOver Popup on explore */
    protected string $tooltipPopup = '';

    /** size multiplier for circles */
    protected int $sizeMultiplier = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Map, $this>
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\MapGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(MapGroup::class, 'group_id');
    }

    /**
     * Get the marker's size, and make it 20 times bigger for a "pixel" size equivalent
     */
    public function size(): int
    {
        return ($this->size_id * 20) + 20;
    }

    /**
     * Determine if the marker is of the label type
     */
    public function isLabel(): bool
    {
        return $this->shape_id == self::SHAPE_LABEL;
    }

    /**
     * Determine if the marker is of the circle type
     */
    public function isCircle(): bool
    {
        return $this->shape_id == self::SHAPE_CIRCLE;
    }

    /**
     * Determine if the marker is of the polygon type and has a custom shape
     */
    public function isPolygon(): bool
    {
        return $this->shape_id == MapMarker::SHAPE_POLY && ! empty($this->custom_shape);
    }

    /**
     * Determine the type of the marker
     */
    public function typeLabel(): string
    {
        if ($this->isPolygon()) {
            return __('maps/markers.tabs.polygon');
        } elseif ($this->isLabel()) {
            return __('maps/markers.tabs.label');
        } elseif ($this->isCircle()) {
            return __('maps/markers.tabs.circle');
        }

        return __('maps/markers.tabs.marker');
    }

    /**
     * Determine the icon of the marker for the datagrid.
     */
    public function datagridMarkerIcon(): string
    {
        if (in_array($this->shape_id, [2, 3, 5])) {
            return '';
        }

        $icon = '<i class="fa-solid fa-map-pin"></i>';

        $campaign = CampaignLocalization::getCampaign();
        if (! empty($this->custom_icon) && $campaign->boosted()) {
            if (Str::startsWith($this->custom_icon, '<i ')) {
                $icon = $this->custom_icon;
            } elseif (Str::startsWith($this->custom_icon, ['fa-', 'ra '])) {
                $icon = ' <i class="' . $this->custom_icon . '" aria-hidden="true"></i>';
            } elseif (Str::startsWith($this->custom_icon, '<?xml')) {
                $icon = '<div class="custom-icon"><img src="' . $this->resizedCustomIcon() . '" /></div>';
            }
        } elseif ($this->icon == 2) {
            $icon = '<i class="fa-solid fa-question"></i>';
        } elseif ($this->icon == 3) {
            $icon = '<i class="fa-solid fa-exclamation"></i>';
        }

        return $icon;
    }

    /**
     * Generate the marker for leaflet
     */
    public function marker(): string
    {
        if ($this->isCircle()) {
            return $this->circleMarker();
        } elseif ($this->isLabel()) {
            return $this->labelMarker();
        } elseif ($this->isPolygon()) {
            $coords = [];
            $segments = explode(' ', str_replace("\r\n", ' ', $this->custom_shape));
            foreach ($segments as $segment) {
                $coord = explode(',', $segment);
                if (! empty($coord[0]) && ! empty($coord[1])) {
                    $coords[] = '[' . $coord[0] . ', ' . Str::before($coord[1], ' ') . ']';
                }
            }

            return 'L.polygon([' . implode(', ', $coords) . '], {
                color: \'' . Arr::get($this->polygon_style, 'stroke', $this->colour) . '\',
                weight: ' . max(1, Arr::get($this->polygon_style, 'stroke-width', 1)) . ',
                opacity: ' . $this->strokeOpacity() . ',
                fillOpacity: ' . $this->floatOpacity() . ',
                fillColor: \'' . e($this->colour) . '\',
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\',
            })' . $this->popup();
            // ' . ($this->editing ? 'draggable: true,' : null) . '
        }

        return 'L.marker([' . $this->latitude . ', ' . $this->longitude . '], {
            title: \'' . $this->markerTitle() . '\',
            opacity: ' . $this->floatOpacity() . ','
            . ($this->isDraggable() ? 'draggable: true,' : null) . '
            ' . $this->markerIcon() . '
        })' . $this->popup() . $this->draggable();
    }

    /**
     * Generate a circle marker
     */
    protected function circleMarker(): string
    {
        return 'L.circle([' . $this->latitude . ', ' . $this->longitude . '], {
                radius: ' . $this->circleRadius() . ',
                fillColor: \'' . e($this->colour) . '\',
                title: \'' . $this->markerTitle() . '\',
                stroke: false,
                fillOpacity: ' . $this->floatOpacity() . ',
                className: \'marker marker-circle marker-' . $this->id . ' size-' . $this->size_id . '\','
            . ($this->isDraggable() ? 'draggable: true' : null) . '
            })' . $this->popup() .  $this->draggable();
    }

    /**
     * Generate a label marker
     */
    protected function labelMarker(): string
    {
        return 'L.marker([' . $this->latitude . ', ' . $this->longitude . '], {
                opacity: 0.1,
                icon: labelShapeIcon,'
            . ($this->editing ? null : null) . '
            }).bindTooltip(`' . str_replace('`', '\'', $this->markerTitle()) . '`, {
                direction: \'center\',
                permanent: true,
                offset: [0,0],
                opacity: ' . $this->floatOpacity() . ',
            })' . $this->popup();
    }

    /**
     * Generate the marker's popup that is usually opened on hover
     */
    protected function popup(): ?string
    {
        if ($this->editing) {
            return null;
        }

        $body = null;
        $campaign = CampaignLocalization::getCampaign();
        if (! empty($this->entity)) {
            if (! empty($this->name)) { // Name is set, include link to the entity
                $url = $this->entity->url();
                if ($this->entity->isMap()) {
                    $url = $this->entity->child->getLink('explore');
                }
                $body .= "<p><a href=\"{$url}\">" . str_replace('`', '\'', $this->entity->name) . '</a></p>';
            }
            // No entry field, include the entity tooltip
            if (! $this->isLabel()) {
                $body .= $this->entity->mappedPreview();
                // Replace backslashes because javascript can think that things like \6e is an octogonal string
                $body = str_replace('\\', '/', $body);
            }
        }

        // When exploring, we want the texts to be slightly shorter, to avoid lots of jittering on maps
        if ($this->isExploring()) {
            $body = Str::limit($body, 300);
            $output = '.on(`click`, function (ev) {
                window.markerDetails(`' . route('maps.markers.details', [$campaign, $this->map_id, $this->id]) . '`)
            })';

            if ($this->is_popupless) {
                return $output;
            }

            return '.bindPopup(`
            <div class="marker-popup-content">
                <h4 class="marker-header">' . str_replace('`', '\'', $this->markerTitle(true)) . '</h4>
                ' . (! empty($this->entry) ? '<p class="marker-text">' . Str::limit(Mentions::mapAny($this), 300) . '</p>' : null) . '
            </div>
            <div class="marker-popup-entry">
                ' . $body . '
            </div>`)
                ' . $this->tooltipPopup . $output;
        }

        $editButton = $copyButton = $deleteButton = '';
        if (auth()->check()) {
            if (auth()->user()->can('update', $this)) {
                $editButton = '<a href="' . route('maps.map_markers.edit', [$campaign, $this->map_id, $this->id]) . '" class="btn2 btn-xs btn-primary">' . __('crud.edit') . '</a>';
                $copyButton = '<a href="' . route('maps.map_markers.create', [$campaign, $this->map_id, 'source' => $this->id]) . '" class="btn2 btn-xs btn-primary">' . __('crud.actions.copy') . '</a>';
            }
            if (auth()->user()->can('delete', $this)) {
                $route = route('confirm-delete', [$campaign, 'route' => route('maps.map_markers.destroy', [$campaign, $this->map_id, $this->id]), 'name' => $this->markerTitle(), 'permanent' => true]);
                $deleteButton = '<a href="#" class="btn2 btn-xs btn-error"
                data-url="' . $route . '" data-toggle="dialog" data-target="primary-dialog"
                        title="' . __('crud.remove') . '">
                    ' . __('crud.remove') . '
                </a>';
            }
        }

        return '.bindPopup(`
            <div class="marker-popup-content">
                <h4 class="marker-header">' . str_replace('`', '\'', $this->markerTitle(true)) . '</h4>
                ' . (! empty($this->entry) ? '<p class="marker-text">' . Mentions::mapAny($this) . '</p>' : null) . '
            </div>
            <div class="marker-popup-body">
            ' . $body . '
            </div>
            <div class="marker-popup-actions flex gap-2">
                ' . $editButton . $copyButton . $deleteButton . '
            </div>`
        )';
    }

    /**
     * Determine if a marker is draggable
     */
    protected function isDraggable(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return $this->editing || ($this->isExploring() && $this->is_draggable);
    }

    /**
     * Generate the draggable event for a marker
     */
    protected function draggable(): string
    {
        if (! $this->isDraggable()) {
            return '';
        }

        // Exploring and moving? Update through ajax
        if ($this->isExploring() && $this->is_draggable) {
            $campaign = CampaignLocalization::getCampaign();

            return '.on(`dragstart`, function() {
                this.closePopup();
            })

            .on(\'dragend\', function() {
                var coordinates = marker' . $this->id . '.getLatLng();
                //console.log(`dragend`, coordinates);
                $.ajax({
                    url: `' . route('maps.markers.move', [$campaign, $this->map_id, $this->id]) . '`,
                    type: `post`,
                    data: {latitude: coordinates.lat.toFixed(3), longitude: coordinates.lng.toFixed(3)}
                }).done(function (data) {
                    console.log(`moved marker`);
                });
            })';
        }

        return '.on(\'dragend\', function() {
            var coordinates = marker' . $this->id . '.getLatLng();
            //console.log(\'coords\', coordinates);
            //console.log(\'new coords\', coordinates.lat, coordinates.lng);

            var shapeId = $(\'input[name="shape_id"]\').val();
            var polyCoords = $(\'textarea[name="custom_shape"]\');
            //console.log(\'shape id\', shapeId);
            if (shapeId == "5") {
                //console.log(\'poly\', polyCoords.val());
                polyCoords.val(polyCoords.val() + \' \' + coordinates.lat.toFixed(3) + \',\' + coordinates.lng.toFixed(3));
            } else {
                $(\'#marker-latitude\').val(coordinates.lat.toFixed(3));
                $(\'#marker-longitude\').val(coordinates.lng.toFixed(3));
            }
        })';
    }

    /**
     * Marker icon as shown in explore and edit mode
     */
    protected function markerIcon(): string
    {
        if ($this->icon == 5) {
            return '';
        }

        $iconStyles = [];
        $iconStyles[] = 'background-color: ' . $this->backgroundColour();

        $iconShape = '<div style="background-color: ' . $this->backgroundColour() . '" class="marker-pin"></div>';

        $icon = '`' . $iconShape . '<i class="fa-solid fa-map-pin"></i>`';

        $campaign = CampaignLocalization::getCampaign();
        if (! empty($this->custom_icon) && $campaign->boosted()) {
            if (Str::startsWith($this->custom_icon, '<i ')) {
                $icon = '`' . $iconShape . $this->custom_icon . '`';
            } elseif (Str::startsWith($this->custom_icon, ['fa-', 'ra '])) {
                $icon = '`' . $iconShape . ' <i class="' . $this->custom_icon . '" aria-hidden="true"></i>`';
            } elseif (Str::startsWith($this->custom_icon, '<?xml')) {
                $icon = 'L.Util.template(`<div class="custom-icon">' . $this->resizedCustomIcon() . '</div>`)';
            }
        } elseif ($this->icon == 2) {
            $icon = '`' . $iconShape . '<i class="fa-solid fa-question"></i>`';
        } elseif ($this->icon == 3) {
            $icon = '`' . $iconShape . '<i class="fa-solid fa-exclamation"></i>`';
        } elseif ($this->icon == 4) {
            $icon = '`' . $iconShape . '`';
        }

        // dd($this->pin_size ?: 40);
        $size = (int) $this->pinSize(false);

        return 'icon: L.divIcon({
                html: ' . $icon . ',
                iconSize: [' . $size . ', ' . $size . '],
                iconAnchor: [' . ceil($size / 2) . ', ' . ($size + ceil($size / 4)) . '],
                popupAnchor: [0, -' . ($size + ceil($size / 4)) . '],
                className: \'marker marker-' . $this->id . '\'
        })';
    }

    public function pinSize(bool $withPx = true): string
    {
        $size = max(10, $this->pin_size ?: 40);

        return (string) $size . ($withPx ? 'px' : null);
    }

    /**
     * The name of the marker: name or entity
     *
     * @param  bool  $link  = false
     */
    public function markerTitle(bool $link = false): string
    {
        if (empty($this->name) && ! empty($this->entity)) {
            if ($link) {
                $url = $this->entity->url();
                if ($this->entity->isMap()) {
                    $url = $this->entity->child->getLink('explore');
                }

                return '<a href="' . $url . '">' . $this->entity->name . '</a>';
            }

            return str_replace("'", "\'", $this->entity->name);
        }

        return $link ? e($this->name) : str_replace("'", "\'", $this->name);
    }

    /**
     * Set the current mode to editing the marker
     */
    public function editing(): self
    {
        $this->editing = true;

        return $this;
    }

    /**
     * Set the current mode to exploring the map
     */
    public function exploring(bool $popup = true): self
    {
        $this->exploring = true;
        if ($popup) {
            $this->tooltipPopup = '.on(`mouseover`, function (ev) {this.openPopup();})';
        }

        return $this;
    }

    /**
     * Determine if the marker is being viewed in the "explore" page.
     * Refactor potential: move all of the rendering logic to a separate class.
     */
    public function isExploring(): bool
    {
        return $this->exploring;
    }

    /**
     * Used for calculating sizes and distances when using open street map where everything is way more
     * zoomed in.
     */
    public function multiplier(bool $isReal = false): self
    {
        $this->sizeMultiplier = $isReal ? 50 : 1;

        return $this;
    }

    /**
     * Get the opacity of a point. Users input a %, convert it to a float for leaflet
     */
    protected function floatOpacity(): float
    {
        if ($this->opacity > 100) {
            return 1.0;
        }

        if (empty($this->opacity) && $this->editing) {
            return 0.5;
        }

        return round($this->opacity / 100, 1);
    }

    /**
     * Get the polygon's stroke opacity
     */
    protected function strokeOpacity(): float
    {
        $opacity = Arr::get($this->polygon_style, 'stroke-opacity');
        if (empty($opacity)) {
            return 1.0;
        }

        // The number is an int (1 to 100), but needs to be a float
        return round($opacity / 100, 1);
    }

    /**
     * Resize any custom svg icon to be limited in height and width to the pin
     */
    protected function resizedCustomIcon(): string
    {
        $resized = preg_replace('`(width|height)=\".*?\"`sui', '$1="32"', $this->custom_icon);
        $resized = str_replace('height="32"', 'height="32" style="margin-top: 4px;"', $resized);

        return $resized;
    }

    /**
     * Marker background colour
     */
    public function backgroundColour(): string
    {
        if (! empty($this->colour)) {
            return $this->colour;
        }

        // Entity with no image? Add a grey background colour to make the pin visible
        if ($this->icon == 4 && $this->entity && ! $this->entity->hasImage()) {
            return '#ccc';
        }

        if ($this->icon != 1 || ! empty($this->custom_icon)) {
            return 'unset';
        }

        return '#ccc';
    }

    /**
     * Check if a marker is visible (pointing to an entity that shouldn't be visible)
     */
    public function visible(): bool
    {
        $campaign = CampaignLocalization::getCampaign();
        if ($this->isPolygon() && ! $campaign->boosted()) {
            return false;
        }
        // Part of a private group, don't show either
        if (! empty($this->group_id) && ! $this->group) {
            return false;
        }

        return empty($this->entity_id) || (! empty($this->entity) && ! $this->entity->isMissingChild());
    }

    /**
     * Calculate the circle radius
     */
    protected function circleRadius(): int
    {
        if (! empty($this->circle_radius)) {
            return (int) $this->circle_radius * $this->sizeMultiplier;
        }

        return (int) ($this->size_id * 20) * ($this->size_id * $this->sizeMultiplier);
    }

    /**
     * For legacy tinymce editor
     */
    public function hasEntity(): bool
    {
        return false;
    }

    /**
     * Functions for the datagrid2
     */
    public function url(string $where): string
    {
        return 'maps.map_markers.' . $where;
    }

    public function routeParams(array $options = []): array
    {
        return $options + ['map' => $this->map_id, 'map_marker' => $this->id];
    }

    public function routeCopyParams(array $options = []): array
    {
        return $options + ['map' => $this->map_id, 'source' => $this->id];
    }

    /**
     * Patch an entity from the datagrid2 batch editing
     */
    public function patch(array $data): bool
    {
        if (isset($data['group_id']) && $data['group_id'] == -1) {
            $data['group_id'] = null;
        }

        return $this->updateQuietly($data);
    }

    /**
     * Override the get link
     */
    public function getLink(): string
    {
        $campaign = CampaignLocalization::getCampaign();

        return route('maps.map_markers.edit', [$campaign, 'map' => $this->map_id, $this->id]);
    }

    /**
     * Generate link for the datagrid
     */
    public function markerLink(?string $displayName = null): string
    {
        return '<a href="' . $this->getLink() . '">' .
            (! empty($displayName) ? $displayName : e($this->name)) .
        '</a>';
    }
}
