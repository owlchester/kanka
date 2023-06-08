<div class="modal-body text-center">
    <x-dialog.close />

    <x-cta :campaign="$campaign" image="0" :cta="__('entities/files.call-to-action.premium')">
        <p>{{ __('entities/files.call-to-action.error') }}</p>
    </x-cta>
</div>

