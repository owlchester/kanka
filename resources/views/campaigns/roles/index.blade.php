<div class="flex gap-2 items-center">
    <h1 class="inline-block grow text-2xl">
        {{ __('campaigns.show.tabs.roles') }}
    </h1>
    <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
            data-target="roles-help">
        <x-icon class="question" />
        {{ __('general.learn-more') }}
    </button>
    @if (auth()->user()->can('update', $campaign))
        <a href="{{ route('campaign_roles.create', $campaign) }}" class="btn2 btn-primary btn-sm"
           data-toggle="dialog-ajax" data-target="role-dialog"
           data-url="{{ route('campaign_roles.create', $campaign) }}"
        >
            <x-icon class="plus" />
            {{ __('campaigns.roles.actions.add') }}
        </a>
    @endif
</div>

<x-grid>
    <x-infoBox
        title="{{ __('campaigns/roles.overview.title') }}"
        icon="{{ $campaign->boosted() ? 'fa-solid fa-infinity text-green-600' : 'fa-solid fa-warning text-red-500' }}"
        subtitle="{{  __('campaigns/roles.overview.' . ($campaign->boosted() ? 'unlimited' : 'limited'), ['total' => $campaign->roleLimit(), 'amount' => $roles->total()]) }}"
        background="{{ $campaign->boosted() ? 'bg-green-200' : 'bg-red-200' }}"
        :campaign="$campaign"
        premium
    ></x-infoBox>
</x-grid>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $plugin
 */?>
    @if(Datagrid::hasBulks())
        <x-form :action="['campaign_roles.bulk', $campaign]" direct>
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        </x-form>
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    @endif

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    @include('partials.helper-modal', [
        'id' => 'roles-help',
        'title' => __('campaigns.show.tabs.roles'),
        'textes' => [
            __('campaigns.roles.helper.1', [
                'admin' => '<a href="' . route(
                    'campaigns.campaign_roles.admin',
                    $campaign,
                ) . '">' .
                    $campaign->adminRoleName() . '</a>',
            ]),
            __('campaigns.roles.helper.2'),
            __('campaigns.roles.helper.3'),
            __('campaigns.roles.helper.4'),
        ]
    ])
    <x-dialog id="role-dialog" :loading="true" />
@endsection
