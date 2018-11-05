<div class="row">
    <div class="col-md-3">
        @include('organisations._menu')
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))
                    <li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}">
                        <a href="#member" data-toggle="tooltip" title="{{ trans('organisations.show.tabs.members') }}">
                            <i class="fa fa-user"></i> <span class="hidden-sm hidden-xs">{{ trans('organisations.show.tabs.members') }}</span>
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
                @if ($campaign->enabled('characters'))
                <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                    @include('organisations._members')
                </div>
                @endif
                @include('cruds._panes')
            </div>
        </div>

        <!-- actions -->
        @include('cruds.boxes.history')
    </div>
</div>
