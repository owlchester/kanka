<div class="box box-solid">
    <div class="box-body">
        @include('partials.errors')
        @include($content)
    </div>
    <div class="box-footer">
        @if (isset($actions))
            @include($actions)
        @else
            <button class="btn btn-success">
                {{ $submit ?? __('crud.save') }}
            </button>
        @endif
        @includeWhen(!request()->ajax(), 'partials.or_cancel')

        @if (isset($deleteID) && !empty($deleteID))
            <div class="pull-left">
                <x-button.delete-confirm target="{{ $deleteID }}" />
            </div>
        @endif
    </div>
</div>
