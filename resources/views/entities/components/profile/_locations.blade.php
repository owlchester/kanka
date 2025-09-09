@if ($campaign->enabled('locations') && !$child->locations->isEmpty())
    <div class="element profile-location">
        <div class="title text-uppercase text-xs">
            {!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}
        </div>
        @php $existingLocations = []; @endphp
        @foreach ($child->locations as $location)
            @if(!empty($existingLocations[$location->id]))
                @continue
            @endif
            @php $existingLocations[$location->id] = true; @endphp
            <x-entity-link
                :entity="$location->entity"
                :campaign="$campaign" />
        @endforeach
    </div>
@endif
