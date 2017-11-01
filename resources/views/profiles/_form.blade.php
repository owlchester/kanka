{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Email:</label>
            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
        </div>
        <hr />
        @if (empty($user->provider))
        <div class="form-group">
            <label>New Password (optional):</label>
            {!! Form::password('password_new', ['placeholder' => 'New Password', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Password confirmation:</label>
            {!! Form::password('password_new_confirmation', ['placeholder' => 'Password confirmation', 'class' => 'form-control']) !!}
        </div>
        <hr />
        @endif

        <div class="form-group">
            <label>Avatar:</label>
            {!! Form::file('avatar', array('class' => 'image')) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>
                {!! Form::checkbox('newsletter') !!}
                Newsletter</label>
        </div>

        @if (empty($user->provider))
        <div class="form-group">
            <label>Current Password:</label>
            {!! Form::password('password', ['placeholder' => 'Provide your current password for any changes', 'class' => 'form-control']) !!}
        </div>
        @endif
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
