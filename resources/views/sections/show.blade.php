<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                @include ('cruds._image')

                <h3 class="profile-username text-center">{{ $model->name }}
                    @if ($model->is_private)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </h3>

                <ul class="list-group list-group-unbordered">
                    @if (!empty($model->type))
                    <li class="list-group-item">
                        <b>{{ trans('sections.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if (!empty($model->section))
                        <li class="list-group-item">
                            <b>{{ trans('crud.fields.section') }}</b>

                            <span class="pull-right">
                            <a href="{{ route('sections.show', $model->section->id) }}" data-toggle="tooltip" title="{{ $model->section->tooltip() }}">{{ $model->section->name }}</a>
                                @if ($model->section->section)
                                    , <a href="{{ route('sections.show', $model->section->section->id) }}" data-toggle="tooltip" title="{{ $model->section->section->tooltip() }}">{{ $model->section->section->name }}</a>
                                @endif
                            </span>
                            <br class="clear" />
                        </li>
                    @endif

                </ul>
                @include('.cruds._actions')
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#information" data-toggle="tooltip" title="{{ trans('sections.show.tabs.information') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs">
                            {{ trans('sections.show.tabs.information') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->get('tab') == 'sections' ? ' active' : '') }}">
                    <a href="#sections" data-toggle="tooltip" title="{{ trans('sections.show.tabs.sections') }}">
                        <i class="fa fa-folder-open"></i> <span class="hidden-sm hidden-xs">
                            {{ trans('sections.show.tabs.sections') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->get('tab') == 'children' ? ' active' : '') }}">
                    <a href="#children" data-toggle="tooltip" title="{{ trans('sections.show.tabs.children') }}">
                        <i class="fa fa-sitemap"></i> <span class="hidden-sm hidden-xs">
                            {{ trans('sections.show.tabs.children') }}</span>
                    </a>
                </li>
                @include('cruds._tabs', ['calendars' => false])
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                    <div class="post">
                        <h3>{{ trans('crud.fields.description') }}</h3>
                        <p>{!! $model->description !!}</p>
                    </div>
                </div>
                <div class="tab-pane" id="sections">
                    @include('sections._sections')
                </div>
                <div class="tab-pane" id="children">
                    @include('sections._children')
                </div>
                @include('cruds._panes')
            </div>
        </div>
        <!-- actions -->
    </div>
</div>
