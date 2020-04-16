<div class="panel panel-default">
    @if ($ajax)
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ __('entities/notes.create.title', ['name' => $entity->name]) }}</h4>
        </div>
    @endif
    <div class="panel-body">

        {!! Form::open(['route' => ['entities.entity_notes.store', $entity->id], 'method'=>'POST', 'data-shortcut' => '1', 'id' => 'entity-form']) !!}
        @include('cruds.notes._form')

        <div class="form-group">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
            @if (!$ajax)
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '#notes') === false ? '#notes' : null))]) !!}
            @endif
        </div>

        {!! Form::close() !!}
    </div>
</div>

@include('editors.editor')
