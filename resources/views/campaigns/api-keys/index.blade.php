<div class="flex gap-2 items-center">
    <h3 class="inline-block grow">
        {{ __('campaigns.show.tabs.api-keys') }}</span>
    </h3>
    @can('update', $campaign)
        <a
            href="{{ route('api-keys.create', $campaign) }}"
            class="btn2 btn-primary btn-sm"
            data-toggle="dialog"
            data-target="primary-dialog"
            data-url="{{ route('api-keys.create', $campaign) }}"
        >
            <x-icon class="plus" />
            {{ __('campaigns/api-keys.actions.add') }}
        </a>
    @endif
</div>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignApiKey $apiKey
 */?>
<div id="datagrid-parent" class="table-responsive">
    @include('layouts.datagrid._table')
</div>
@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])
@endsection
