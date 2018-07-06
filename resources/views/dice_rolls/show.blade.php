<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-body box-profile">
                @include ('cruds._image')

                <h3 class="profile-username text-center">{{ $model->name }}</h3>

                <ul class="list-group list-group-unbordered">
                    @if ($campaign->enabled('characters') && $model->character)
                        <li class="list-group-item">
                            <b>{{ trans('crud.fields.character') }}</b>
                            <span  class="pull-right">
                                <a href="{{ route('characters.show', $model->character) }}">{{ $model->character->name }}</a>
                                </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->parameters)
                        <li class="list-group-item">
                            <b>{{ trans('dice_rolls.fields.parameters') }}</b> <span class="pull-right">{{ $model->parameters }}</span>
                            <br class="clear" />
                        </li>
                    @endif
                    @include('cruds.layouts.section')
                </ul>

                @include('.cruds._actions')
            </div>
        </div>
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
    </div>
</div>
