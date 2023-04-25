<div class="modal-body text-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

    <x-cta :campaign="$campaign" image="0" :cta="__('entities/files.call-to-action.premium')">
        <p>{{ __('entities/files.call-to-action.error') }}</p>
    </x-cta>
</div>

