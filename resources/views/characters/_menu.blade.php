<?php /** @var App\Models\character $model */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        <div class="row">
            <div class="col-md-12 col-sm-4 col-xs-4">
                @include ('cruds._image')
            </div>
            <div class="col-md-12 col-sm-8 col-xs-8">

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

                <ul class="list-group list-group-unbordered">
                    @if ($campaign->enabled('families') && $model->family)
                        <li class="list-group-item">
                            <b>{{ __('characters.fields.family') }}</b>
                            <a class="pull-right" href="{{ route('families.show', $model->family_id) }}" data-toggle="tooltip" title="{{ $model->family->tooltip() }}">{{ $model->family->name }}</a>
                            <br class="clear" />
                        </li>
                    @endif
                    @include('cruds.lists.location')
                    @if ($campaign->enabled('races') && $model->race)
                        <li class="list-group-item">
                            <b>{{ __('characters.fields.race') }}</b>
                            <a class="pull-right" href="{{ route('races.show', $model->race_id) }}" data-toggle="tooltip" title="{{ $model->race->tooltip() }}">{{ $model->race->name }}</a>
                            <br class="clear" />
                        </li>
                    @endif
                    @if (!empty($model->type))
                        <li class="list-group-item">
                            <b>{{ __('characters.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                            <br class="clear" />
                        </li>
                    @endif

                    @include('entities.components.tags')
                    @include('entities.components.files')

                </ul>

                @include('.cruds._actions')
            </div>
        </div>
    </div>
</div>

@include('entities.components.menu')