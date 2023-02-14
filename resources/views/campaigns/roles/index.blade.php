<div class="mb-2">
    <div class="pull-right">
        <button class="btn btn-default btn-sm" data-toggle="dialog"
                data-target="roles-help">
            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
            {{ __('campaigns.members.actions.help') }}
        </button>
        @if (auth()->user()->can('update', $campaign))
            <a href="{{ route('campaign_roles.create', $campaign) }}" class="btn btn-primary btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('campaign_roles.create', $campaign) }}"
            >
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                {{ __('campaigns.roles.actions.add') }}
            </a>
        @endif
    </div>
    <h3 class="mt-0 inline-block">
        {{ __('campaigns.show.tabs.roles') }} <small>({{ $roles->total() }} / @if ($limit = $campaign->roleLimit()){{ $limit }}@else<i class="fa-solid fa-infinity"></i>@endif)</small>
    </h3>
</div>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $plugin
 */?>
    <div class="box box-solid">
        @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['campaign_roles.bulk', $campaign]]) !!} @endif
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
                    'campaign_roles.admin',
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
@endsection
