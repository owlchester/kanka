@inject('dateRenderer', 'App\Renderers\DateRenderer')
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')

            <h1 class="profile-username text-center">{{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
            </h1>
        @endif

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
                        {!! $model->character->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')
            @include('entities.components.calendar')
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>
        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')
