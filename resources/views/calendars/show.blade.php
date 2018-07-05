@include('partials.errors')
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
                        <b>{{ trans('calendars.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if ($model->suffix)
                    <li class="list-group-item">
                        <b>{{ trans('calendars.fields.suffix') }}</b> <span class="pull-right">{{ $model->suffix }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if ($model->date)
                    <li class="list-group-item">
                        <b>{{ trans('calendars.fields.date') }}</b> <span class="pull-right">{{ $model->date }}</span>
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
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#information" data-toggle="tooltip" title="{{ trans('calendars.show.tabs.information') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('calendars.show.tabs.information') }}</span>
                    </a>
                </li>
                @include('cruds._tabs', ['calendars' => false])
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                    @if (!empty($model->description))
                    <div class="post">
                        <h3>{{ trans('crud.fields.description') }}</h3>
                        <p>{!! $model->description !!}</p>
                    </div>
                    @endif

                    @include('calendars._calendar')
                </div>
                @include('cruds._panes', ['calendars' => false])
            </div>
        </div>
        <!-- actions -->
        @include('cruds.boxes.history')
    </div>
</div>
