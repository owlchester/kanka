<?php /** @var App\Models\character $model */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
            <h3 class="profile-username text-center">{{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
                @endif
                @if ($model->is_dead)
                    <span class="ra ra-skull" title="{{ __('characters.hints.is_dead') }}"></span>
                @endif
            </h3>
            @if ($model->title)
                <p class="text-muted text-center">{{ $model->title }}</p>
            @endif
        @endif

        <ul class="list-group list-group-unbordered">
            @if ($campaign->enabled('families') && $model->family)
                <li class="list-group-item">
                    <b>{{ __('characters.fields.family') }}</b>
                    <span class="pull-right">
                        {!! $model->family->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')
            @if ($campaign->enabled('races') && $model->race)
                <li class="list-group-item">
                    <b>{{ __('characters.fields.race') }}</b>
                    <span class="pull-right">
                        {!! $model->race->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ __('characters.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
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