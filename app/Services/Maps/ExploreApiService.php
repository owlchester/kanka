<?php

namespace App\Services\Maps;

use App\Enums\Visibility;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;

class ExploreApiService
{
    use CampaignAware;

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

    protected function translations(): array
    {
        return [
            'legend_title' => __('maps.panels.legend'),
            'legend_search' => __('maps/explorer.legend.search'),
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
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'shape' => __('maps/explorer.marker.shape'),
            'group' => __('maps/explorer.marker.group'),
            'none' => __('maps/explorer.marker.none'),
            'visibility' => __('maps/explorer.marker.visibility'),
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'toolbar' => [
                'rapid' => __('maps/explorer.toolbar.rapid'),
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
        ];
    }
}
