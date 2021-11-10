@if ($campaign->enabled('locations') && !empty($model->location))
    <div class="element profile-location">
        <div class="title">{{ __('crud.fields.location') }}</div>
        {!! $model->location->tooltipedLink() !!}
    </div>
@endif
