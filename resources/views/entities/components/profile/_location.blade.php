@if ($campaign->enabled('locations') && !empty($model->location))
    <div class="element profile-location">
        <div class="title text-uppercase text-xs">{!! \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location')) !!}</div>
        {!! $model->location->tooltipedLink() !!}
    </div>
@endif
