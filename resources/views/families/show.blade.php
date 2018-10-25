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
                    @include('entities.components.tags')
                    @include('entities.components.files')
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
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('characters'))<li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}">
                    <a href="#member" data-toggle="tooltip" title="{{ trans('families.show.tabs.member') }}">
                        <i class="fa fa-user"></i> <span class="hidden-sm hidden-xs">{{ trans('families.show.tabs.member') }}</span>
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
                    @include('families._members')
                </div>
                @endif
                @include('cruds._panes')
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>
</div>
