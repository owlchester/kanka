<div class="row">
    <div class="col-md-3">
        @include('dice_rolls._menu')
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#results" data-toggle="tooltip" title="{{ trans('dice_rolls.show.tabs.results') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs"> {{ trans('dice_rolls.show.tabs.results') }}
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="results">
                    @include('dice_rolls._results')
                </div>
                @include('cruds._panes')
            </div>
        </div>
        @include('cruds.boxes.history')
        @include('entities.components.notes')
    </div>
</div>
