{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
        </div>

        <div class="row">
            <div class="col-md-6">
                @include('cruds.fields.visibility')
            </div>
        </div>
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}