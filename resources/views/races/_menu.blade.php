<?php /** @var App\Models\location $location */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if ($model->race)
                <li class="list-group-item">
                    <b>{{ trans('characters.fields.race') }}</b>
                    <a class="pull-right" href="{{ route('races.show', $model->race_id) }}" data-toggle="tooltip" title="{{ $model->race->tooltip() }}">{{ $model->race->name }}</a>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->type)
                <li class="list-group-race">
                    <b>{{ trans('races.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.layouts.section')
        </ul>

        @include('.cruds._actions')
    </div>
</div>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('races.show.tabs.menu') }}
        </h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@if(empty($active))active @endif">
                <a href="{{ route('races.show', $model) }}">
                    {{ __('crud.panels.entry') }}
                </a>
            </li>
            @if ($campaign->enabled('characters'))
            <li class="@if(!empty($active) && $active == 'characters')active @endif">
                <a href="{{ route('races.characters', $model) }}">
                    {{ __('races.show.tabs.characters') }}
                    <span class="label label-default pull-right">
                        <?=$model->characters()->count()?>
                    </span>
                </a>
            </li>
            @endif
            <li class="@if(!empty($active) && $active == 'races')active @endif">
                <a href="{{ route('races.races', $model) }}">
                    {{ __('races.show.tabs.races') }}
                    <span class="label label-default pull-right">
                        <?=$model->races()->count()?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>