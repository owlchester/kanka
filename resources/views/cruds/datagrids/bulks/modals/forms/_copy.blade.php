<x-grid type="1/1">
    <p class="m-0 text-neutral-content">
        {{ __('entities/move.panel.description_bulk_copy') }}
    </p>

    <x-forms.field field="campaign" :label="__('entities/move.fields.campaign')">
        {!! Form::select('campaign', Auth::user()->moveCampaignList($campaign, false), null, ['class' => 'w-full']) !!}
    </x-forms.field>

    @includeIf($type . '.bulk.modals._copy_to_campaign')
</x-grid>
