<div class="flex gap-2 items-center">
    <h3 class="inline-block grow">
        {{ __('campaigns.show.tabs.webhooks') }}</span>
    </h3>
    @if ($campaign->premium())
    <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
            data-target="webhooks-help">
        <x-icon class="question" />
        {{ __('crud.actions.help') }}
    </button>
    @if (auth()->user()->can('update', $campaign))
        <a href="{{ route('webhooks.create', $campaign) }}" class="btn2 btn-primary btn-sm"
           data-url="{{ route('webhooks.create', $campaign) }}"
        >
            <x-icon class="plus" />
            {{ __('campaigns/webhooks.actions.add') }}
        </a>
    @endif
    @endif
</div>
@if (!$campaign->premium())
    <x-cta :campaign="$campaign" premium>
        <p>{!! __('campaigns/webhooks.pitch') !!}</p>
    </x-cta>
@else
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
