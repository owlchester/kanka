<h4 class="">{{ __('crud.fields.closed') }}</h4>
<div class="checkbox">
    {!! Form::hidden('is_closed', 0) !!}
    <label>
        {!! Form::checkbox('is_closed', 1, empty($model) ? false : $model->is_closed) !!}
        {!! __('crud.fields.is_closed') !!}
    </label>
</div>
