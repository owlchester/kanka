<div class="panel panel-default">
    @if ($ajax)
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ __('entities/notes.create.title', ['name' => $entity->name]) }}</h4>
        </div>
    @endif
    <div class="panel-body">
        @include('cruds.notes._form')

        @include('cruds.notes._saveOptions')
    </div>
</div>

@include('editors.editor')
