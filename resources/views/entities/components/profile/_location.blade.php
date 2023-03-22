@if ($campaignService->enabled('locations') && !empty($model->location))
    <div class="element profile-location">
        <div class="title text-uppercase text-xs">{{ __('entities.location') }}</div>
        {!! $model->location->tooltipedLink() !!}
    </div>
@endif
