<div class="box">
    <div class="box-body">
        @include('partials.errors')
        @include($content)
    </div>
    <div class="box-footer flex gap-2 items-center justify-between">
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
