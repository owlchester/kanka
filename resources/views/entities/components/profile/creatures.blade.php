<?php /** @var \App\Models\Map $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements grid my-1 collapse in" id="sidebar-profile-elements">

        @if ($campaignService->enabled('locations') && !$model->locations->isEmpty())
            <div class="element profile-location">
                <div class="title text-uppercase text-xs">
                    {{ __('creatures.fields.locations') }}
                </div>
                @php $existingLocations = []; @endphp
                @foreach ($model->locations as $location)
                    @if(!empty($existingLocations[$location->id]))
                        @continue
                    @endif
                    @php $existingLocations[$location->id] = true; @endphp
                    {!! $location->tooltipedLink() !!}
                @endforeach
            </div>
        @endif

        @include('entities.components.profile._type')
    </div>
</div>
