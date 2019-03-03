<?php /** @var \App\Models\Character $model */?>
<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('characters._menu')
    </div>

    <div class="col-lg-8 col-md-6">
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
                    <p>{!! $model->entry !!}</p>
                    @include('cruds.partials.mentions')
                </div>
                @include('cruds._panes')
            </div>
        </div>

        @if (($model->is_personality_visible || (!$model->is_personality_visible && Auth::check() && Auth::user()->can('personality', $model))) && $model->characterTraits()->personality()->count() > 0)
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('characters.show.tabs.personality') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach ($model->characterTraits()->personality()->orderBy('default_order')->get() as $trait)
                    <p><b>{{ $trait->name }}</b><br />{!! nl2br(e($trait->entry)) !!}</p>
                @endforeach

                @if (Auth::check() && Auth::user()->can('personality', $model))
                <p class="help-block export-hidden">{{ trans('characters.hints.hide_personality') }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-2 col-md-3">
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

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @include('cruds.boxes.history')
    </div>
</div>

@if(isset($exporting))
    @if ($campaign->enabled('items') && $model->items()->count() > 0)
        @include('characters.panels.items')
    @endif
    @if ($campaign->enabled('organisations') && $model->organisations()->count() > 0)
        @include('characters.panels.organisations')
    @endif
    @if ($campaign->enabled('journals') && $model->journals()->count() > 0)
        @include('characters.panels.journals')
    @endif
    @if ($campaign->enabled('quests') && $model->quests()->count() > 0)
        @include('characters.panels.quests')
    @endif
    @if ($campaign->enabled('dice_rolls') && $model->diceRolls()->count() > 0)
        @include('characters.panels.dice_rolls')
    @endif
    @if ($campaign->enabled('conversations') && $model->conversations()->count() > 0)
        @include('characters.panels.conversations')
    @endif
@endif
