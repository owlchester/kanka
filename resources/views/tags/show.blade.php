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
                    @if (!empty($model->type))
                    <li class="list-group-item">
                        <b>{{ trans('tags.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if (!empty($model->tag))
                        <li class="list-group-item">
                            <b>{{ trans('crud.fields.tag') }}</b>

                            <span class="pull-right">
                            <a href="{{ route('tags.show', $model->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tooltip() }}">{{ $model->tag->name }}</a>
                                @if ($model->tag->tag)
                                    , <a href="{{ route('tags.show', $model->tag->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tag->tooltip() }}">{{ $model->tag->tag->name }}</a>
                                @endif
                            </span>
                            <br class="clear" />
                        </li>
                    @endif

                </ul>
                @include('.cruds._actions')
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs">
                            {{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->get('tab') == 'tags' ? ' active' : '') }}">
                    <a href="#tags" data-toggle="tooltip" title="{{ trans('tags.show.tabs.tags') }}">
                        <i class="fa fa-tags"></i> <span class="hidden-sm hidden-xs">
                            {{ trans('tags.show.tabs.tags') }}</span>
                    </a>
                </li>
                @include('cruds._tabs', ['calendars' => false])
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <div class="post">
                        <p>{!! $model->entry !!}</p>
                    </div>
                </div>
                <div class="tab-pane" id="tags">
                    @include('tags._tags')
                </div>
                @include('cruds._panes')
            </div>
        </div>

        <div class="box box-flat">
            <div class="box-body">
                <h2 class="page-header with-border">
                    {{ trans('tags.show.tabs.children') }}
                </h2>
                @include('tags._children')
            </div>
        </div>

        <!-- actions -->
        @include('cruds.boxes.history')
    </div>
</div>
