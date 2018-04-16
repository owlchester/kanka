{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            @if (empty($user->provider))
                <label>{{ trans('profiles.fields.password') }}</label>
                {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
            @endif
        </div>
    </div>
</div>
