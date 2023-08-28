<div class="flex gap-2 items-center">
    <h3 class="inline-block grow">
        {{ __('campaigns.show.tabs.roles') }} <span class="text-sm">({{ $roles->total() }} / @if ($limit = $campaign->roleLimit()){{ $limit }}@else<i class="fa-solid fa-infinity" aria-hidden="true"></i>@endif)</span>
    </h3>
    <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
            data-target="roles-help">
        <x-icon class="question"></x-icon>
        {{ __('crud.actions.help') }}
    </button>
    @if (auth()->user()->can('update', $campaign))
        <a href="{{ route('campaign_roles.create', $campaign) }}" class="btn2 btn-primary btn-sm"
           data-toggle="dialog-ajax" data-target="role-dialog"
           data-url="{{ route('campaign_roles.create', $campaign) }}"
        >
            <x-icon class="plus"></x-icon>
            {{ __('campaigns.roles.actions.add') }}
        </a>
    @endif
</div>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $plugin
 */?>
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['campaign_roles.bulk', $campaign]]) !!} @endif
    <div id="datagrid-parent">
        @include('layouts.datagrid._table', ['responsive' => true])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

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
                    $campaign,
                    ['target' => '_blank']
                )
            ]),
            __('campaigns.roles.helper.2'),
            __('campaigns.roles.helper.3'),
            __('campaigns.roles.helper.4'),
        ]
    ])
    <x-dialog id="role-dialog" :loading="true" />
@endsection
