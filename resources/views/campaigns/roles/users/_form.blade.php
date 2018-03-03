{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('campaigns.roles.users.fields.name') }}</label>
            {!! Form::select('user_id', $campaign->membersList(), null, ['placeholder' => trans('campaigns.roles.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
