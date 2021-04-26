<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
            @include('entities.components.links')
        @endif

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->ability))
                <li class="list-group-item">
                    <b>{{ trans('abilities.fields.ability') }}</b>
                    <span class="pull-right">
                        {!! $model->ability->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.type')
            @if ($model->charges)
                <li class="list-group-item">
                    <b>{{ trans('abilities.fields.charges') }}</b> <span class="pull-right">{{ $model->charges }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
        </ul>
    </div>
</div>

@includeWhen(!isset($exporting), 'entities.components.menu')
@includeWhen(auth()->check() && !isset($exporting), 'entities.components.actions')
