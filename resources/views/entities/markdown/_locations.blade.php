@if ($campaign->enabled('locations') && $entity->locations->isNotEmpty())
## {!! __('crud.tabs.profile') !!}

* **{!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}:** {!! $entity->locations->pluck('name')->map(fn($name) => html_entity_decode($name, ENT_QUOTES, 'UTF-8'))->implode(', ') !!}
@endif
