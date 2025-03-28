
@if (!isset($skipCancel))
    <menu class="flex flex-wrap gap-3 ps-0 ms-0">
        <button autofocus type="button" class="btn2 btn-outline" onclick="this.closest('dialog').close('close')">
            {{ __('crud.cancel') }}
        </button>
    </menu>
@endif
<menu class="flex flex-wrap gap-3 ps-0">
    @if (isset($deleteID) && !empty($deleteID))
        <x-button.delete-confirm target="{{ $deleteID }}" />
    @endif
    @if (isset($actions))
        @includeWhen(!empty($actions), $actions)
    @else
        <div class="submit-group">
            <button class="btn2 btn-primary">
                {{ $submit ?? __('crud.save') }}
            </button>
        </div>
    @endif
</menu>
