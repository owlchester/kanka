<div class="flex gap-2 items-center">
    <h3 class="inline-block grow">
        {{ __('campaigns.show.tabs.webhooks') }}</span>
    </h3>
    <x-learn-more url="features/campaigns/webhooks.html" />
    @can('update', $campaign)
        <a
            href="{{ route('webhooks.create', $campaign) }}"
            class="btn2 btn-primary btn-sm"
            data-toggle="dialog"
            data-target="primary-dialog"
            data-url="{{ route('webhooks.create', $campaign) }}"
        >
            <x-icon class="plus" />
            {{ __('campaigns/webhooks.actions.add') }}
        </a>
    @endif
</div>

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Webhook $webhook
 */?>
    @if(Datagrid::hasBulks())
        <x-form :action="['webhooks.bulk', $campaign]" direct>
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
        'id' => 'webhooks-help',
        'title' => __('campaigns.show.tabs.webhooks'),
        'textes' => [
            __('campaigns/webhooks.helper.1'),
            __('campaigns/webhooks.helper.2'),
            __('campaigns/webhooks.helper.3'),
        ]
    ])
@endsection
