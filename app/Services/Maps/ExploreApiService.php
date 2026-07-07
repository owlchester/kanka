<?php

namespace App\Services\Maps;

use App\Enums\Visibility;
use App\Facades\CampaignCache;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class ExploreApiService
{
    use CampaignAware;
    use UserAware;

    protected Map $map;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function load(): array
    {
        $mapEntity = $this->map->entity;

        return [
            'map' => new MapResource($this->map)->campaign($this->campaign),
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->typeName() === 'overlay_shown' && $layer->hasImage())
                    ->values()
            ),
            'groups' => GroupResource::collection($this->map->groups),
            'pins' => $this->map->markers
                ->filter(fn ($marker) => $marker->visible())
                ->values()
                ->map(fn ($marker) => new PinResource($marker)->campaign($this->campaign)->mapEntity($mapEntity))
                ->all(),
            'visibilities' => $this->visibilityOptions(),
            'default_visibility_id' => $this->campaign->defaultVisibility()->value,
            'i18n' => $this->translations(),
            'interactive' => $this->interactive(),
        ];
    }

    /**
     * Visibility options available when creating a brand new marker. Mirrors the "new record"
     * branch of resources/views/entities/pages/posts/forms/_visibility.blade.php: Self/AdminSelf
     * are always offered (the current user will become the creator), Admin/Member only for admins.
     */
    protected function visibilityOptions(): array
    {
        $options = [
            ['id' => Visibility::All->value, 'name' => __('crud.visibilities.all')],
        ];

        if (auth()->user()->can('admin', $this->campaign)) {
            $options[] = ['id' => Visibility::Admin->value, 'name' => __('crud.visibilities.admin')];
            $options[] = ['id' => Visibility::Member->value, 'name' => __('crud.visibilities.members')];
        }

        $options[] = ['id' => Visibility::Self->value, 'name' => __('crud.visibilities.self')];
        $options[] = ['id' => Visibility::AdminSelf->value, 'name' => __('crud.visibilities.admin-self')];

        return $options;
    }

    protected function interactive(): ?array
    {
        $key = config('broadcasting.connections.reverb.key');
        if (empty($key) || ! $this->hasUser()) {
            return null;
        }

        if (! $this->user->can('view', $this->map->entity)) {
            return null;
        }

        return [
            'key' => $key,
            'host' => config('broadcasting.connections.reverb.options.host'),
            'port' => config('broadcasting.connections.reverb.options.port'),
            'scheme' => config('broadcasting.connections.reverb.options.scheme'),
            'channel' => 'map.' . $this->map->id,
            'show_presence' => CampaignCache::campaign($this->campaign)->members()->count() > 1,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }

    protected function translations(): array
    {
        return [
            'legend_title' => __('maps.panels.legend'),
            'legend_search' => __('maps/explorer.legend.search'),
            'legend_expand' => __('maps/explorer.legend.expand'),
            'legend_collapse' => __('maps/explorer.legend.collapse'),
            'ungrouped' => __('maps/explorer.ungrouped'),
            'loading' => __('maps/explorer.loading'),
            'error_load' => __('maps/explorer.errors.load'),
            'error_delete' => __('maps/explorer.errors.delete'),
            'error_save' => __('maps/explorer.errors.save'),
            'from_entry' => __('maps/explorer.marker.from_entry'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'edit_details' => __('maps/explorer.marker.edit'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('maps/explorer.marker.save'),
            'save_continue' => __('maps/explorer.marker.save_continue'),
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'shape' => __('maps/explorer.marker.shape'),
            'group' => __('maps/explorer.marker.group'),
            'none' => __('maps/explorer.marker.none'),
            'visibility' => __('maps/explorer.marker.visibility'),
            'colour' => __('maps/explorer.marker.colour'),
            'border_colour' => __('maps/explorer.marker.border_colour'),
            'stroke_width' => __('maps/explorer.marker.stroke_width'),
            'stroke_thin' => __('maps/explorer.marker.stroke_thin'),
            'stroke_normal' => __('maps/explorer.marker.stroke_normal'),
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
            'opacity' => __('maps/explorer.marker.opacity'),
            'custom' => __('maps/explorer.marker.custom'),
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'toolbar' => [
                'rapid' => __('maps/explorer.toolbar.rapid'),
                'rapid_hint' => __('maps/explorer.toolbar.rapid_hint'),
                'pin' => __('maps/explorer.toolbar.pin'),
                'text' => __('maps/explorer.toolbar.text'),
                'area' => __('maps/explorer.toolbar.area'),
                'circle' => __('maps/explorer.toolbar.circle'),
                'path' => __('maps/explorer.toolbar.path'),
                'helper' => [
                    'pin' => __('maps/explorer.toolbar.helper.pin'),
                    'text' => __('maps/explorer.toolbar.helper.text'),
                    'area' => __('maps/explorer.toolbar.helper.area'),
                    'circle' => __('maps/explorer.toolbar.helper.circle'),
                    'path' => __('maps/explorer.toolbar.helper.path'),
                ],
            ],
            'header' => [
                'overview' => __('maps/explorer.header.overview'),
                'settings' => __('maps/explorer.header.settings'),
                'edit' => __('maps/explorer.header.edit'),
            ],
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps/explorer.settings.grid'),
                'zoom_min' => __('maps/explorer.settings.zoom_min'),
                'zoom_max' => __('maps/explorer.settings.zoom_max'),
                'zoom_initial' => __('maps/explorer.settings.zoom_initial'),
                'distance_name' => __('maps/explorer.settings.distance_name'),
                'distance_measure' => __('maps/explorer.settings.distance_measure'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps/explorer.settings.center_coordinates'),
                'center_marker' => __('maps/explorer.settings.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'save' => __('maps/explorer.settings.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
            'presence' => [
                'role_edit' => __('maps/explorer.presence.role_edit'),
                'role_view' => __('maps/explorer.presence.role_view'),
                'error_unavailable' => __('maps/explorer.presence.error_unavailable'),
                'error_connecting' => __('maps/explorer.presence.error_connecting'),
                'error_disconnected' => __('maps/explorer.presence.error_disconnected'),
            ],
        ];
    }
}
