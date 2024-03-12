@if ($campaign->enabled('locations') && !empty($model->location))
| {!! \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location')) !!} | {!! $model->location->tooltipedLink() !!} |
@endif
