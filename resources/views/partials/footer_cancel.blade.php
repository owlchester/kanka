@if(request()->ajax() || (isset($ajax) && $ajax))
    <button type="button" class="btn2 btn-ghost" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
        {{ __('crud.cancel') }}
    </button>
@else
    <a href="{{ url()->previous() }}" class="btn2 btn-ghost">
        {{ __('crud.cancel') }}
    </a>
@endif
