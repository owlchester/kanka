<div class="flex gap-2 items-center justify-between">
    <h1 class="inline-block text-2xl">
        {{ __('campaigns.show.tabs.webhooks') }}
    </h1>
    <div class="flex gap-1">
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
</div>

<p>
    {!! __('campaigns/webhooks.helper.tutorial') !!}
</p>

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
