<x-grid type="1/1">
    <x-helper>
        <p>
        {{ __('entities/move.panel.description_bulk_copy') }}
        </p>
    </x-helper>

    <x-forms.field field="campaign" :label="__('entities/move.fields.campaign')">
        <x-forms.select name="campaign" :options="auth()->user()->moveCampaignList($campaign, false)" class="w-full" />
    </x-forms.field>

    @includeIf($type . '.bulk.modals._copy_to_campaign')
</x-grid>
