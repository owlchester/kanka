<div class="row">
    <div class="col-md-3">
        @include('quests._menu')
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
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <p>{!! $model->entry() !!}</p>
                    @include('cruds.partials.mentions')
                </div>

                <div class="tab-pane {{ (request()->get('tab') == 'quests' ? ' active' : '') }}" id="quests">
                    @include('quests._quests')
                </div>
                @include('cruds._panes')
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>
</div>

@if (isset($exporting))
    @if ($campaign->enabled('characters'))
        @include('quests.panels.characters')
    @endif
    @if ($campaign->enabled('locations'))
        @include('quests.panels.locations')
    @endif
    @if ($campaign->enabled('items'))
        @include('quests.panels.items')
    @endif
    @if ($campaign->enabled('organisations'))
        @include('quests.panels.organisations')
    @endif
@endif