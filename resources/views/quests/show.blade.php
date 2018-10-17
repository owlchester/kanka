<div class="row">
    <div class="col-md-3">
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

                    @include('cruds.layouts.calendar')
                    @include('cruds.layouts.tags')
                </ul>

                @include('.cruds._actions', ['disableMove' => true])
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->get('tab') == 'quests' ? ' active' : '') }}">
                    <a href="#quests" data-toggle="tooltip" title="{{ trans('quests.show.tabs.quests') }}">
                        <i class="ra ra-wooden-sign"></i> <span class="hidden-sm hidden-xs">{{ trans('quests.show.tabs.quests') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                    <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}">
                        <a href="#character" data-toggle="tooltip" title="{{ trans('quests.show.tabs.characters') }}">
                            <i class="fa fa-user"></i> <span class="hidden-sm hidden-xs">{{ trans('quests.show.tabs.characters') }}</span>
                        </a>
                    </li>
                @endif
                @if ($campaign->enabled('locations'))
                    <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}">
                        <a href="#location" data-toggle="tooltip" title="{{ trans('quests.show.tabs.locations') }}">
                            <i class="fa fa-globe"></i> <span class="hidden-sm hidden-xs">{{ trans('quests.show.tabs.locations') }}</span>
                        </a>
                    </li>
                @endif
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <div class="post">
                        <p>{!! $model->entry !!}</p>
                    </div>
                </div>

                <div class="tab-pane {{ (request()->get('tab') == 'quests' ? ' active' : '') }}" id="quests">
                    @include('quests._quests')
                </div>
                @if ($campaign->enabled('characters'))
                    <div class="tab-pane {{ (request()->get('tab') == 'character' ? ' active' : '') }}" id="character">
                        @include('quests._characters')
                    </div>
                @endif
                @if ($campaign->enabled('locations'))
                    <div class="tab-pane {{ (request()->get('tab') == 'location' ? ' active' : '') }}" id="location">
                        @include('quests._locations')
                    </div>
                @endif
                @include('cruds._panes')
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>
</div>