<div class="row">
    <div class="col-md-2">
        <div class="box">
            <div class="box-body box-profile">
                @include ('cruds._image')

                <h3 class="profile-username text-center">{{ $model->name }}
                @if ($model->is_private)
                     <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($model->is_dead)
                     <span class="ra ra-skull" title="{{ trans('characters.hints.is_dead') }}"></span>
                @endif
                </h3>

                @if ($model->title)
                    <p class="text-muted text-center">{{ $model->title }}</p>
                @endif

                <ul class="list-group list-group-unbordered">
                    @if ($campaign->enabled('families') && $model->family)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.family') }}</b>
                            <a class="pull-right" href="{{ route('families.show', $model->family_id) }}" data-toggle="tooltip" title="{{ $model->family->tooltip() }}">{{ $model->family->name }}</a>
                            <br class="clear" />
                        </li>
                    @endif
                    @if ($campaign->enabled('locations') && $model->location)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.location') }}</b>
                            <span  class="pull-right">
                                <a href="{{ route('locations.show', $model->location_id) }}" data-toggle="tooltip" title="{{ $model->location->tooltip() }}">{{ $model->location->name }}</a>@if ($model->location->parentLocation),
                                <a href="{{ route('locations.show', $model->location->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->location->parentLocation->tooltip() }}">{{ $model->location->parentLocation->name }}</a>
                                @endif
                            </span>
                            <br class="clear" />
                        </li>
                    @endif
                    @if (!empty($model->race))
                    <li class="list-group-item">
                        <b>{{ trans('characters.fields.race') }}</b> <span class="pull-right">{{ $model->race }}</span>
                        <br class="clear" />
                    </li>
                    @endif
                    @if (!empty($model->type))
                    <li class="list-group-item">
                        <b>{{ trans('characters.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                        <br class="clear" />
                    </li>
                    @endif

                    @include('cruds.layouts.section')
                </ul>

                @include('.cruds._actions')
            </div>
        </div>

        <!-- About Me Box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('characters.fields.physical') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <ul class="list-group list-group-unbordered">
                    @if ($model->age)
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

    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#history" title="{{ trans('characters.show.tabs.history') }}" data-toggle="tooltip">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('characters.show.tabs.history') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                    <div class="post">
                        <p>{!! $model->history !!}</p>
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

        @if ($campaign->enabled('journals') && $model->journals()->count() > 0)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.show.tabs.journals') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('characters.panels.journals')
                </div>
            </div>
        @endif
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        @if ($campaign->enabled('items') && $model->items()->count() > 0)
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('characters.show.tabs.items') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('characters.panels.items')
            </div>
        </div>
        @endif
        @if ($campaign->enabled('organisations') && $model->organisations()->count() > 0)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.show.tabs.organisations') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('characters.panels.organisations')
                </div>
            </div>
        @endif

        @if ($campaign->enabled('dice_rolls') && $model->diceRolls()->count() > 0)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.show.tabs.dice_rolls') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('characters.panels.dice_rolls')
                </div>
            </div>
        @endif

        @if ($campaign->enabled('quests') && $model->quests()->count() > 0)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.show.tabs.quests') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('characters.panels.quests')
                </div>
            </div>
        @endif

        @if ($campaign->enabled('conversations') && $model->conversations()->count() > 0)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.show.tabs.conversations') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('characters.panels.conversations')
                </div>
            </div>
        @endif
    </div>
</div>
