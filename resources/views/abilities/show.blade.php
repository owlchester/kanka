<div class="row">
    <div class="col-md-3">
        @include('abilities._menu')
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @include('cruds._tabs', ['disableAttributes' => true])
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <p>{!! $model->entry() !!}</p>
                    @include('cruds.partials.mentions')
                </div>
                @include('cruds._panes', ['disableAttributes' => true])
            </div>
        </div>

        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    {{ __('crud.tabs.attributes') }}
                </h3>
            </div>
            <div class="box-body">

            @include('cruds._attributes')
            </div>
        </div>

        @include('cruds.boxes.history')
    </div>
</div>


@if (isset($exporting))
    @include('abilities.panels.abilities')
@endif
