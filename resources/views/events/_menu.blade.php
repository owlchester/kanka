<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
        @include ('cruds._image')
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
