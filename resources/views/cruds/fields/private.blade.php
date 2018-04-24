@if (Auth::user()->isAdmin())
    <div class="form-group">
        {!! Form::hidden('is_private', 0) !!}
        <label>{!! Form::checkbox('is_private') !!}
            {{ trans('crud.fields.is_private') }}
        </label>
        <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
    </div>
@endif