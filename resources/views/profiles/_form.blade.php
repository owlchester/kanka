{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('profiles.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('profiles.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('profiles.fields.email') }}</label>
            {!! Form::text('email', null, ['placeholder' => trans('profiles.placeholders.email'), 'class' => 'form-control']) !!}
        </div>
        <hr />

        <div class="form-group">
            <label>
                {!! Form::hidden('newsletter', 0) !!}
                {!! Form::checkbox('newsletter') !!}
                {{ trans('profiles.fields.newsletter') }}</label>
        </div>

        @if (empty($user->provider))
        <div class="form-group">
            <label>{{ trans('profiles.fields.password') }}</label>
            {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
        </div>
        @endif
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
