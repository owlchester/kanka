@if ($campaign->enabled('locations') && $model->location)
    <li class="list-group-item">
        <b>
            <i class="ra ra-tower" title="{{ trans('crud.fields.location') }}"></i> <span class="visible-xs-inline">{{ trans('characters.fields.location') }}</span>
        </b>
        <span class="pull-right">
            {!! $model->location->tooltipedLink() !!}@if ($model->location->parentLocation),
                {!! $model->location->parentLocation->tooltipedLink() !!}
            @endif
        </span>
        <br class="clear" />
    </li>
@endif