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
        @if (empty($user->provider))
        <div class="form-group">
            <label>{{ trans('profiles.fields.new_password') }}</label>
            {!! Form::password('password_new', ['placeholder' => trans('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('profiles.fields.new_password_confirmation') }}</label>
            {!! Form::password('password_new_confirmation', ['placeholder' => trans('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
        </div>
        <hr />
        @endif

        <div class="form-group">
            <label>{{ trans('profiles.fields.avatar') }}:</label>
            {!! Form::file('avatar', array('class' => 'image')) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>
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
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
