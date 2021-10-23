
@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-th-large"></i> {{ __('campaigns.show.tabs.settings') }}
        </h3>
        <div class="box-tools">
            <button class="btn btn-secondary btn-sm" data-toggle="modal"
                    data-target="#settings-help">
                <i class="fas fa-question-circle" aria-hidden="true"></i>
                {!! __('campaigns.members.actions.help') !!}
            </button>
        </div>
    </div>
</div>

{!! Form::model($campaign->setting, ['method' => 'POST', 'route' => ['campaigns.settings.save']]) !!}
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-user', 'module' => 'characters'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-tower', 'module' => 'locations'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dragon', 'module' => 'races'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-double-team', 'module' => 'families'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-gem-pendant', 'module' => 'items'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-quill-ink', 'module' => 'notes'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-moon-sun', 'module' => 'calendars'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-calendar', 'module' => 'events'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-scroll-unfurled', 'module' => 'journals'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-hood', 'module' => 'organisations'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-wooden-sign', 'module' => 'quests'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-tags', 'module' => 'tags'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-fire-symbol', 'module' => 'abilities'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-map', 'module' => 'maps'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-clock', 'module' => 'timelines'])
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dice-five', 'module' => 'dice_rolls'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'ra ra-speech-bubbles', 'module' => 'conversations'])
    </div>
    <div class="col-md-4">
        @include('campaigns.settings.box', ['icon' => 'fa fa-link', 'module' => 'menu_links'])
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        @include('campaigns.settings.box', ['icon' => 'fas fa-suitcase', 'module' => 'inventories'])
    </div>
</div>

        <button class="btn btn-success btn-block">
            <i class="fa fa-check"></i> {{ __('crud.save') }}
        </button>

{!! Form::close() !!}



@section('modals')

    <div class="modal fade" id="settings-help" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('campaigns.show.tabs.settings') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {!! __('campaigns.settings.helper', ['admin' => link_to_route(
        'campaigns.campaign_roles.admin',
        \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')),
        null,
        ['target' => '_blank']
)]) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
