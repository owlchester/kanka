<div class="bg-box rounded-xl p-4 flex flex-col gap-6 lg:gap-12 shadow-xs">
    <div class="flex flex-col gap-4">
        @include('partials.errors')
        @include($content)
    </div>
    <div class="flex gap-2 items-center justify-between">
        <div class="flex gap-2 items-center">
            @include('partials.footer_cancel')

            @if (isset($actions))
                @include($actions)
            @endif

            @if (isset($deleteID) && !empty($deleteID))
                <x-button.delete-confirm target="{{ $deleteID }}" />
            @endif
        </div>

        <button class="btn2 btn-primary">
            {{ $submit ?? __('crud.save') }}
        </button>
    </div>
</div>
