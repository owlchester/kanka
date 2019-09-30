@include('partials.errors')
<div class="row">
    <div class="col-md-2">
        @include('calendars._menu')
    </div>

    <div class="col-md-10">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @include('cruds._tabs', ['calendars' => false])
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    @if ($model->hasEntry())
                        <p>{!! $model->entry() !!}</p>
                    @endif

                    @include('calendars._calendar')
                    @include('cruds.partials.mentions')
                </div>
                @include('cruds._panes', ['calendars' => false])
            </div>
        </div>
        <!-- actions -->
        @include('cruds.boxes.history')
    </div>
</div>
