<form method="POST" action="{{ $route }}">
    @csrf
    <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"
                aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title mb-5">
            {{ __('crud.bulk.edit.title') }}
        </h3>

        @include('layouts.datagrid.bulks.' . $view)

    </div>
    <div class="modal-footer">
        <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
        <button class="btn btn-success" type="submit">
            <i class="fa-solid fa-save" aria-hidden="true"></i>
            {{ __('crud.actions.apply') }}
        </button>
    </div>

@foreach ($models as $model)
    <input type="hidden" name="model[]" value="{{ $model }}" />
@endforeach
<input type="hidden" name="action" value="patch" />
</form>
