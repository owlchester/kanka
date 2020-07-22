<div class="row">
    <div class="col-md-3">
        @include('maps._menu')
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <p>{!! $model->entry() !!}</p>

                    @if (!empty($model->image))
                    <a href="{{ route('maps.explore', $model) }}" class="btn btn-block btn-primary" target="_blank">
                        <i class="fa fa-map"></i> {{ __('maps.actions.explore') }}
                    </a>
                    @endif

                    @include('cruds.partials.mentions')

                </div>
                @include('cruds._panes')
            </div>
        </div>

        @include('cruds.boxes.history')
    </div>
</div>


@if (isset($exporting))
    @include('maps.panels.maps')
@endif
