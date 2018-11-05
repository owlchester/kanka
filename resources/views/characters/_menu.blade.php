<?php /** @var App\Models\character $character */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        <div class="row">
            <div class="col-md-12 col-sm-4 col-xs-4">
                @include ('cruds._image')
            </div>
            <div class="col-md-12 col-sm-8 col-xs-8">

                <h3 class="profile-username text-center">{{ $model->name }}
                    @if ($model->is_private)
                        <i class="fa fa-lock" title="{{ __('crud.is_private') }}"></i>
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

@if (!isset($exporting))
<div class="box box-solid">
    <div class="box-header with-border hidden-xs">
        <h3 class="box-title">
            {{ __('crud.tabs.menu') }}
        </h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@if(empty($active))active @endif">
                <a href="{{ route('characters.show', $model) }}">
                    {{ __('crud.panels.entry') }}
                </a>
            </li>
            {{--<li class="@if(!empty($active) && $active == 'map')active @endif">--}}
                {{--<a href="{{ route('characters.map', $model) }}">--}}
                    {{--{{ __('characters.show.tabs.map') }}--}}
                {{--</a>--}}
            {{--</li>--}}
            @if ($campaign->enabled('items') && $model->items()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'items')active @endif">
                    <a href="{{ route('characters.items', $model) }}" title="{{ __('characters.show.tabs.items') }}">
                        {{ __('characters.show.tabs.items') }}
                        <span class="label label-default pull-right">
                        <?=$model->items()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
            @if ($campaign->enabled('organisations') && $model->organisations()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'organisations')active @endif">
                    <a href="{{ route('characters.organisations', $model) }}" title="{{ __('characters.show.tabs.organisations') }}">
                        {{ __('characters.show.tabs.organisations') }}
                        <span class="label label-default pull-right">
                        <?=$model->organisations()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
            @if ($campaign->enabled('journals') && $model->journals()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'journals')active @endif">
                    <a href="{{ route('characters.journals', $model) }}" title="{{ __('characters.show.tabs.journals') }}">
                        {{ __('characters.show.tabs.journals') }}
                        <span class="label label-default pull-right">
                        <?=$model->journals()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
            @if ($campaign->enabled('quests') && $model->quests()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'quests')active @endif">
                    <a href="{{ route('characters.quests', $model) }}" title="{{ __('characters.show.tabs.quests') }}">
                        {{ __('characters.show.tabs.quests') }}
                        <span class="label label-default pull-right">
                        <?=$model->quests()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
            @if ($campaign->enabled('dice_rolls') && $model->diceRolls()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'dice_rolls')active @endif">
                    <a href="{{ route('characters.dice_rolls', $model) }}" title="{{ __('characters.show.tabs.dice_rolls') }}">
                        {{ __('characters.show.tabs.dice_rolls') }}
                        <span class="label label-default pull-right">
                        <?=$model->diceRolls()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
            @if ($campaign->enabled('conversations') && $model->conversations()->acl()->count() > 0)
                <li class="@if(!empty($active) && $active == 'conversations')active @endif">
                    <a href="{{ route('characters.conversations', $model) }}" title="{{ __('characters.show.tabs.conversations') }}">
                        {{ __('characters.show.tabs.conversations') }}
                        <span class="label label-default pull-right">
                        <?=$model->conversations()->acl()->count()?>
                    </span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif