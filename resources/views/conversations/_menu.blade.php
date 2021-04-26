<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
        @include ('cruds._image')
        @include('entities.components.links')
        @endif

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ trans('conversations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            <li class="list-group-item">
                <b>{{ trans('conversations.fields.target') }}</b>
                <span class="pull-right">
                            {{ trans('conversations.targets.' . $model->target) }}
                        </span>
                <br class="clear" />
            </li>
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
        </ul>
    </div>
</div>

@includeWhen(!isset($exporting), 'entities.components.menu')
@includeWhen(auth()->check() && !isset($exporting), 'entities.components.actions')
