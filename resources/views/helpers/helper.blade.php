@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('helpers.' . $helper . '.title'),
    'breadcrumbs' => false,
])

@section('content')

    @if (!request()->ajax())<div class="box box-solid">@endif

        @if (request()->ajax())
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ __('helpers.' . $helper . '.title') }}</h4>
            </div>
        @endif
        <div class="{{ request()->ajax() ? 'modal-body' : 'box-body' }}">
            @includeIf('helpers.' . $helper)
        </div>
        @if (request()->ajax())
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                    {{ __('crud.click_modal.close') }}
                </button>
            </div>
        @endif

    @if (!request()->ajax())</div>@endif

@endsection
