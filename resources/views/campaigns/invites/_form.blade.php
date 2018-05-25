{{ csrf_field() }}
<div class="form-group required">
    <label>{{ trans('campaigns.invites.fields.email') }}</label>
    {!! Form::text('email', null, ['placeholder' => trans('campaigns.invites.placeholders.email'), 'class' => 'form-control']) !!}
</div>
<div class="form-group required">
    <label>{{ trans('campaigns.invites.fields.role') }}</label>
    {!! Form::select('role_id', Auth::user()->campaign->roles()->pluck('name', 'id'), null, ['class' => 'select form-control']) !!}
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('campaigns.invites.create.button') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
