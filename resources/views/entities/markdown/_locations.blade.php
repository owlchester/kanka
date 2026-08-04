@if ($campaign->enabled('locations') && $entity->locations->isNotEmpty())
## {!! __('crud.tabs.profile') !!}

- **{!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}:** {!! implode(', ', $entityData['locations']) !!}
@endif
