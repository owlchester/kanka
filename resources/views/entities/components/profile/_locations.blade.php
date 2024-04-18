@if ($campaign->enabled('locations') && !$model->locations->isEmpty())
    <div class="element profile-location">
        <div class="title text-uppercase text-xs">
            {!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}
        </div>
        @php $existingLocations = []; @endphp
        @foreach ($model->locations()->with('entity')->get() as $location)
            @if(!empty($existingLocations[$location->id]))
                @continue
            @endif
            @php $existingLocations[$location->id] = true; @endphp
            {!! $location->tooltipedLink() !!}
        @endforeach
    </div>
@endif
