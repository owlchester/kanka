<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->quest)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.quest') }}</b>
                    <span class="pull-right">
                        {!! $model->quest->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.character') }}</b>
                    <span  class="pull-right">
                        {!! $model->character->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->is_completed)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.is_completed') }}</b>
                    <span class="pull-right">{{ trans('voyager.generic.yes') }}</span>
                </li>
            @endif

            @include('entities.components.calendar')
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions', ['disableMove' => true])
    </div>
</div>

@include('entities.components.menu')
