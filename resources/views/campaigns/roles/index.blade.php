<div class="flex gap-2 mb-5 items-center">
    <h3 class="m-0 inline-block grow">
        {{ __('campaigns.show.tabs.roles') }} <small>({{ $roles->total() }} / @if ($limit = $campaign->roleLimit()){{ $limit }}@else<i class="fa-solid fa-infinity" aria-hidden="true"></i>@endif)</small>
    </h3>
    <button class="btn btn-default btn-sm" data-toggle="dialog"
            data-target="roles-help">
        <x-icon class="question"></x-icon>
        {{ __('campaigns.members.actions.help') }}
    </button>
    @if (auth()->user()->can('update', $campaign))
        <a href="{{ route('campaign_roles.create') }}" class="btn btn-primary btn-sm"
           data-toggle="ajax-modal" data-target="#entity-modal"
           data-url="{{ route('campaign_roles.create') }}"
        >
            <x-icon class="plus"></x-icon>
            {{ __('campaigns.roles.actions.add') }}
        </a>
    @endif
</div>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $plugin
 */?>
    <div class="box box-solid">
        @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'campaign_roles.bulk']) !!} @endif
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
        @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
    </div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    @php
        $role = \App\Facades\CampaignCache::adminRole();
    @endphp
    @include('partials.helper-modal', [
        'id' => 'roles-help',
        'title' => __('campaigns.show.tabs.roles'),
        'textes' => [
            __('campaigns.roles.helper.1', [
                'admin' => link_to_route(
                    'campaigns.campaign_roles.admin',
                    \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')),
                    null,
                    ['target' => '_blank']
                )
            ]),
            __('campaigns.roles.helper.2'),
            __('campaigns.roles.helper.3'),
            __('campaigns.roles.helper.4'),
        ]
    ])
@endsection
