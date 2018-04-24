{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('crud.notes.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('crud.notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('crud.notes.fields.entry') }}</label>
            {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
        </div>

        @include('cruds.fields.private')
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}