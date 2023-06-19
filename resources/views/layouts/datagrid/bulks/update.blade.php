<form method="POST" action="{{ $route }}">
    @csrf
    <div class="modal-body">
        <x-dialog.close />
        <h3 class="modal-title mb-5">
            {{ __('crud.bulk.edit.title') }}
        </h3>

        <x-grid type="1/1">
            @include('layouts.datagrid.bulks.' . $view)
        </x-grid>

        <x-dialog.footer>
            <button class="btn2 btn-primary" type="submit">
                <x-icon class="save"></x-icon>
                {{ __('crud.actions.apply') }}
            </button>
        </x-dialog.footer>
    </div>

@foreach ($models as $model)
    <input type="hidden" name="model[]" value="{{ $model }}" />
@endforeach
<input type="hidden" name="action" value="patch" />
</form>
