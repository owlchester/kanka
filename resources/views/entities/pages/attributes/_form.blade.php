{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('entities/attributes.fields.attribute') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('entities/attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('entities/attributes.fields.value') }}</label>
            {!! Form::text('value', null, ['placeholder' => trans('entities/attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        @if (Auth::user()->isAdmin())
        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private') !!}
                {{ trans('crud.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
        </div>
        @endif
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}
