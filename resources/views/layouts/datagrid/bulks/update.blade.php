<form method="POST" action="{{ $route }}">
    @csrf
    <div class="modal-body">
        <x-dialog.close />
        <h3 class="modal-title mb-5">
            {{ __('crud.bulk.edit.title') }}
        </h3>

        @include('layouts.datagrid.bulks.' . $view)

    </div>
    <div class="modal-footer">
        <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
        <button class="btn btn-success" type="submit">
            <x-icon class="save"></x-icon>
            {{ __('crud.actions.apply') }}
        </button>
    </div>

@foreach ($models as $model)
    <input type="hidden" name="model[]" value="{{ $model }}" />
@endforeach
<input type="hidden" name="action" value="patch" />
</form>
