<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
        @include ('cruds._image')
        @include('entities.components.links')
        @endif

        <ul class="list-group list-group-unbordered">
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('events.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->date)
                <li class="list-group-item">
                    <b>{{ trans('events.fields.date') }}</b> <span class="pull-right">{{ $model->date }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')

            @if ($model->event)
                <li class="list-group-item">
                    <b>{{ __('events.fields.event') }}</b>
                    <span class="pull-right">
                    {!! $model->event->tooltipedLink() !!}
                </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('events.fields.character') }}</b>
                    <span class="pull-right">
                        {!! $model->character->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
        </ul>
    </div>
</div>
@include('entities.components.menu')
@include('entities.components.actions')
