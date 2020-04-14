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

@include('entities.components.menu')
@include('entities.components.actions')
