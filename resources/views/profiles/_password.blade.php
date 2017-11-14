{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('profiles.fields.password') }}</label>
            {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('profiles.fields.new_password') }}</label>
            {!! Form::password('password_new', ['placeholder' => trans('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('profiles.fields.new_password_confirmation') }}</label>
            {!! Form::password('password_new_confirmation', ['placeholder' => trans('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
