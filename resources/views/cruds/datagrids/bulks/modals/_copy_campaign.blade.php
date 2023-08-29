
<div class="modal-header">
    <x-dialog.close :modal="true" />
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.copy_to_campaign.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <p class="help-block">
        {{ __('entities/move.panel.description_bulk_copy') }}
    </p>

    <x-forms.field field="campaign" :label="__('entities/move.fields.campaign')">
        {!! Form::select('campaign', Auth::user()->moveCampaignList($campaign, false), null, ['class' => 'w-full']) !!}
    </x-forms.field>

    @if(view()->exists($type . '.bulk.modals._copy_to_campaign'))
        @include($type . '.bulk.modals._copy_to_campaign')
    @endif

    <x-dialog.footer :modal="true">
        <button class="btn2 btn-primary" type="submit">
            <i class="fa-solid fa-clone" aria-hidden="true"></i>
            {{ __('crud.actions.copy_to_campaign') }}
        </button>
    </x-dialog.footer>
</div>
<input type="hidden" name="datagrid-action" value="copy-campaign" />
