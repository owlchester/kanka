<?php /** @var App\Models\location $location */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')

            <h3 class="profile-username text-center">{{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
            </h3>
        @endif

        <ul class="list-group list-group-unbordered">
            @if ($model->race)
                <li class="list-group-item">
                    <b>{{ trans('characters.fields.race') }}</b>
                    <span class="pull-right">
                        {!! $model->race->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('races.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif

            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')
