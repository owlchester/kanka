@if(request()->ajax())
    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
        {{ __('crud.cancel') }}
    </button>
@else
    <a href="{{ url()->previous() }}" class="btn btn-default">
        {{ __('crud.cancel') }}
    </a>
@endif
