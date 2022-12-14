<div class="modal-body">
    @include('partials.modals.close')
    <div class="quick-creator-header mt-8 pb-4 mb-4">
        <div>
            <div class="text-2xl">
                @if (isset($titleIcon) && !empty($titleIcon))
                    <span>{!! $titleIcon !!}</span>
                @endif
                {{ $title }}
            </div>
        </div>
    </div>
    @include('partials.errors')
    @include($content)
</div>
<div class="modal-footer">
    @if (isset($actions))
        @include($actions)
    @else
    <button class="btn btn-success">
        {{ $submit ?? __('crud.save') }}
    </button>
    @endif
    <div class="pull-left">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
            {{ __('crud.cancel') }}
        </button>
        @if (isset($deleteID) && !empty($deleteID))
            <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
               title="{{ __('crud.delete_modal.title') }}"
               data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                           <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='{{ $deleteID }}'>{{ __('crud.remove') }}</a>">
                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
            </a>
        @endif
    </div>
</div>
