@if ($campaign->enabled('locations') && $model->location)
    <li class="list-group-item">
        <b>
            <i class="ra ra-tower" title="{{ trans('crud.fields.location') }}"></i> <span class="visible-xs-inline">{{ trans('characters.fields.location') }}</span>
        </b>
        <span class="pull-right">
            <a href="{{ route('locations.show', $model->location_id) }}" data-toggle="tooltip" title="{{ $model->location->tooltip() }}">{{ $model->location->name }}</a>@if ($model->location->parentLocation),
            <a href="{{ route('locations.show', $model->location->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->location->parentLocation->tooltip() }}">{{ $model->location->parentLocation->name }}</a>
            @endif
        </span>
        <br class="clear" />
    </li>
@endif