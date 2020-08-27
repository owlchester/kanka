<div class="row">
    <div class="col-md-3">
        @include('families._menu')
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
                    @include('cruds.partials.mentions')
                </div>
                @include('cruds._panes')
            </div>
        </div>

        @include('families.panels._members')

        @include('cruds.boxes.history')
    </div>
</div>


@if (isset($exporting))
    @include('families.panels.families')
    @if ($campaign->enabled('characters'))
        @include('families.panels.members')
        @include('families.panels.all_members')
    @endif
@endif
