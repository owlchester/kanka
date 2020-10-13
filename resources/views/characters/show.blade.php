<?php /** @var \App\Models\Character $model */?>
<div class="row">
    <div class="@if($model->showAppearance()) col-lg-2 col-md-3 @else col-md-3 @endif">
        @include('characters._menu')
    </div>

    <div class="@if($model->showAppearance()) col-lg-8 col-md-6 @else col-md-9 @endif">
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
                    <p>{!! $model->entry() !!}</p>
                    @include('cruds.partials.mentions')
                </div>
                @include('cruds._panes')
            </div>
        </div>

        @if (((Auth::check() && Auth::user()->can('personality', $model)) || $model->is_personality_visible) && $model->characterTraits()->personality()->count() > 0)
        <div class="box box-solid">
            <div class="box-header">
            @if(auth()->check() && auth()->user()->can('personality', $model))
                <span class="pull-right">
                @if (!$model->is_personality_visible)
                    <i class="fa fa-lock" title="{{ __('characters.hints.personality_not_visible') }}" data-toggle="tooltip"></i>
                @else
                    <i class="fa fa-lock-open" title="{{ __('characters.hints.personality_visible') }}" data-toggle="tooltip"></i>
                @endif
                </span>
            @endif

                <h3 class="box-title">{{ trans('characters.show.tabs.personality') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach ($model->characterTraits()->personality()->orderBy('default_order')->get() as $trait)
                    <p><b>{{ $trait->name }}</b><br />{!! nl2br(e($trait->entry)) !!}</p>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-2 col-md-3 @if (!$model->showAppearance()) hidden @endif">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ trans('characters.fields.physical') }}</h3>
            </div>
            <div class="box-body">

                <ul class="list-group list-group-unbordered">
                    @include('entities.components.elasped_events')
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
    @if ($campaign->enabled('quests') && $model->relatedQuests()->count() > 0)
        @include('characters.panels.quests')
    @endif
    @if ($campaign->enabled('dice_rolls') && $model->diceRolls()->count() > 0)
        @include('characters.panels.dice_rolls')
    @endif
    @if ($campaign->enabled('conversations') && $model->conversations()->count() > 0)
        @include('characters.panels.conversations')
    @endif
@endif
