
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('campaigns.show.tabs.settings') }}
        </h2>

        <p class="help-block">{{ trans('campaigns.settings.helper') }}</p>
    </div>
</div>

{!! Form::model($campaign->setting, ['method' => 'POST', 'route' => ['campaigns.settings.save', $campaign->id]]) !!}
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-moon-sun', 'module' => 'calendars'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-user', 'module' => 'characters'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-calendar', 'module' => 'events'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-double-team', 'module' => 'families'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-link', 'module' => 'menu_links'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-gem-pendant', 'module' => 'items'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-scroll-unfurled', 'module' => 'journals'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-tower', 'module' => 'locations'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-quill-ink', 'module' => 'notes'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dragon', 'module' => 'races'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-hood', 'module' => 'organisations'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-wooden-sign', 'module' => 'quests'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-tags', 'module' => 'tags'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dice-five', 'module' => 'dice_rolls'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-speech-bubbles', 'module' => 'conversations'])
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>

{!! Form::close() !!}