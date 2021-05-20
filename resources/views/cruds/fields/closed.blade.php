@if (auth()->user()->isAdmin())
<hr />
<h4 class="">{{ __('crud.fields.closed') }}</h4>
<div class="checkbox">
    <label>
        {!! Form::checkbox('is_closed', 1, empty($model) ? false : $model->is_private) !!}
        {!! __('crud.fields.is_closed') !!}
    </label>
</div>
@endif
