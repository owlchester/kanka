<div class="box">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
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
                                <a href="{{ route('quests.show', $model->quest->id) }}" data-toggle="tooltip" title="{{ $model->quest->tooltip() }}">
                                    {{ $model->quest->name }}
                                </a>
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.character') }}</b>
                    <span  class="pull-right">
                            <a href="{{ route('characters.show', $model->character->id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">
                                {{ $model->character->name }}
                            </a>
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
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions', ['disableMove' => true])
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
                    <a href="{{ route('quests.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                    <li class="@if(!empty($active) && $active == 'characters')active @endif">
                        <a href="{{ route('quests.characters', $model) }}">
                            {{ __('quests.show.tabs.characters') }}
                            <span class="label label-default pull-right">
                        <?=$model->characters()->acl()->count()?>
                    </span>
                        </a>
                    </li>
                @endif

                @if ($campaign->enabled('locations'))
                    <li class="@if(!empty($active) && $active == 'locations')active @endif">
                        <a href="{{ route('quests.locations', $model) }}">
                            {{ __('quests.show.tabs.locations') }}
                            <span class="label label-default pull-right">
                        <?=$model->locations()->acl()->count()?>
                    </span>
                        </a>
                    </li>
                @endif

                @if ($campaign->enabled('items'))
                    <li class="@if(!empty($active) && $active == 'items')active @endif">
                        <a href="{{ route('quests.items', $model) }}">
                            {{ __('quests.show.tabs.items') }}
                            <span class="label label-default pull-right">
                        <?=$model->items()->acl()->count()?>
                    </span>
                        </a>
                    </li>
                @endif

                @if ($campaign->enabled('organisations'))
                    <li class="@if(!empty($active) && $active == 'organisations')active @endif">
                        <a href="{{ route('quests.organisations', $model) }}">
                            {{ __('quests.show.tabs.organisations') }}
                            <span class="label label-default pull-right">
                        <?=$model->organisations()->acl()->count()?>
                    </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif