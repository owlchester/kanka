@inject('dateRenderer', 'App\Renderers\DateRenderer')
<div class="box">
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
                    <b>{{ trans('journals.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->date)
                <li class="list-group-item">
                    <b>{{ trans('journals.fields.date') }}</b> <span class="pull-right">{{ $dateRenderer->render($model->date) }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->character)
                <li class="list-group-item">
                    <b>{{ trans('journals.fields.author') }}</b>
                    <span class="pull-right">
                                    <a href="{{ route('characters.show', $model->character_id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">{{ $model->character->name }}</a>
                                </span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')
            @include('entities.components.calendar')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>
        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')