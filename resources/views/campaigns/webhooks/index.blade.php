<x-campaigns.page-header
    :title="__('campaigns.show.tabs.webhooks')"
    learn-more-url="features/campaigns/webhooks.html"
    :lead="__('campaigns/webhooks.helper.tutorial')"
>
    <x-slot name="actions">
        @can('update', $campaign)
            @if ($campaign->premium())
                <a
                    href="{{ route('webhooks.create', $campaign) }}"
                    class="btn2 btn-primary btn-sm"
                    data-toggle="dialog"
                    data-url="{{ route('webhooks.create', $campaign) }}"
                >
                    <x-icon class="plus" />
                    {{ __('campaigns/webhooks.actions.add') }}
                </a>
            @endif
        @endif
    </x-slot>
</x-campaigns.page-header>

@if (!$campaign->premium())
    <x-premium-cta-alert :campaign="$campaign" source="webhooks">
        <x-slot name="title">
            {!! __('campaigns/webhooks.cta.title') !!}
        </x-slot>
        <x-slot name="lead">
            {!! __('campaigns/webhooks.cta.lead') !!}
        </x-slot>
    </x-premium-cta-alert>
@endif

<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Webhook $webhook
 */?>
@if ($rows->total() === 0)
    <x-box class="border-dashed border-neutral-content border">
        <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2 text-center">
            <div class="font-bold text-lg">{{ __('campaigns/webhooks.empty.title') }}</div>
            <p class="text-neutral-content mb-4">{{ __('campaigns/webhooks.empty.description') }}</p>

            @if ($campaign->premium())
                <a href="{{ route('webhooks.create', $campaign) }}" class="btn2 btn-primary"
                   data-toggle="dialog"
                   data-url="{{ route('webhooks.create', $campaign) }}">
                    <x-icon class="plus" />
                    {{ __('campaigns/webhooks.actions.add') }}
                </a>
            @endif
        </div>
    </x-box>
@elseif(Datagrid::hasBulks())
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
