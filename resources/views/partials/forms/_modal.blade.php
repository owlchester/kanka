<div class="modal-body">
    <div class="quick-creator-header mt-8 pb-4 mb-4">
        <div>
            <div class="text-2xl">
                @if (isset($titleIcon) && !empty($titleIcon))
                    <span>{!! $titleIcon !!}</span>
                @endif
                {!! $title !!}
            </div>
        </div>
    </div>
    @include('partials.errors')
    @include($content)
</div>
<div class="modal-footer">
    @if (isset($actions))
        @includeWhen(!empty($actions), $actions)
    @else
    <button class="btn2 btn-primary">
        {{ $submit ?? __('crud.save') }}
    </button>
    @endif
    <div class="pull-left">
        <button type="button" class="btn2 btn-ghost" data-dismiss="modal" aria-label="{{ __('crud.actions.close') }}">
            {{ __('crud.cancel') }}
        </button>
        @if (isset($deleteID) && !empty($deleteID))
            <x-button.delete-confirm target="{{ $deleteID }}" />
        @endif
    </div>
</div>
