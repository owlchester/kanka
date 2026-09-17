@if ($campaign->enabled('locations') && $entity->locations->isNotEmpty())
- **{!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}:** {!! implode(', ', $entityData['locations']) !!}
@endif
