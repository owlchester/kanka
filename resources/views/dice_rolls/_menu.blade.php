<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
            @include('entities.components.links')
        @endif

        <ul class="list-group list-group-unbordered">
            @if ($campaign->enabled('characters') && $model->character)
                <li class="list-group-item">
                    <b>{{ trans('crud.fields.character') }}</b>
                    <span  class="pull-right">
                                <a href="{{ route('characters.show', $model->character) }}">{{ $model->character->name }}</a>
                                </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->parameters)
                <li class="list-group-item">
                    <b>{{ trans('dice_rolls.fields.parameters') }}</b> <span class="pull-right">{{ $model->parameters }}</span>
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
