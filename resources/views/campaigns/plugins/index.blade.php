<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="flex gap-2 items-center">
    <h3 class="inline-block grow">
        {{ __('campaigns.show.tabs.plugins') }}
    </h3>
    <a href="{{ config('marketplace.url') }}" target="_blank" class="btn2 btn-primary">
        {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa-solid fa-external-link-alt"></i>
    </a>
</div>

@if($campaign->boosted())
    @if(Datagrid::hasBulks())
        <x-form :action="['campaign_plugins.bulk', $campaign]" direct>
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table', ['empty' => __('campaigns/plugins.empty_list')])
            </div>
        </x-form>
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table', ['empty' => __('campaigns/plugins.empty_list')])
        </div>
    @endif
@else
    <x-cta :campaign="$campaign">
        <p>{!! __('campaigns/plugins.pitch', ['marketplace' => '<a href="' . config('marketplace.url') . '" target="_blank">' . __('footer.plugins'). '</a>']) !!}</p>
    </x-cta>
@endif


@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    <x-dialog id="plugin-update" :loading="true"></x-dialog>
@endsection
