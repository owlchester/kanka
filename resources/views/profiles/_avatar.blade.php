{{ csrf_field() }}
<div class="form-group">
    {!! Form::file('avatar', array('class' => 'image')) !!}
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
