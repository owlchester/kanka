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
                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                               <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='{{ $deleteID }}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        @endif
    </div>
</div>
