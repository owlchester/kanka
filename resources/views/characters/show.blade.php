<div class="row">
    <div class="col-md-3">
        @include('characters._menu')
    </div>

    <div class="col-md-7">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <div class="post">
                        <p>{!! $model->entry !!}</p>
                    </div>
                </div>
                @include('cruds._panes')
            </div>
        </div>

        @if (Auth::check() && Auth::user()->can('personality', $model))
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('characters.show.tabs.personality') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach ($model->characterTraits()->personality()->orderBy('default_order')->get() as $trait)
                    <p><b>{{ $trait->name }}</b><br />{!! nl2br(e($trait->entry)) !!}</p>
                @endforeach
                <p class="help-block export-hidden">{{ trans('characters.hints.hide_personality') }}</p>
            </div>
        </div>
        @endif

        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        <!-- About Me Box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('characters.fields.physical') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <ul class="list-group list-group-unbordered">
                    @if ($model->age || $model->age === '0')
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.age') }}</b> <span class="pull-right">{{ $model->age }}</span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($model->sex)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.sex') }}</b> <span class="pull-right">{{ $model->sex }}</span>
                            <br class="clear" />
                        </li>
                    @endif
                    @foreach ($model->characterTraits()->appearance()->orderBy('default_order')->get() as $trait)
                        <li class="list-group-item">
                            <b>{{ $trait->name }}</b> <span class="pull-right">{{ $trait->entry }}</span>
                            <br class="clear" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
