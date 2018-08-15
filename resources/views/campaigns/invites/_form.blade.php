{{ csrf_field() }}
<div class="form-group required">
@if ($type == 'email')
    <label>{{ trans('campaigns.invites.fields.email') }}</label>
    {!! Form::text('email', null, ['placeholder' => trans('campaigns.invites.placeholders.email'), 'class' => 'form-control']) !!}
@else
    <label>{{ trans('campaigns.invites.fields.validity') }}</label>
    {!! Form::select('validity', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 10 => 10], null, ['class' => 'form-control']) !!}
    <p class="help-block">{{ trans('campaigns.invites.helpers.validity') }}</p>
@endif
</div>

<div class="form-group required">
    <label>{{ trans('campaigns.invites.fields.role') }}</label>
    {!! Form::select('role_id', Auth::user()->campaign->roles()->where('is_public', false)->pluck('name', 'id'), null, ['class' => 'select form-control']) !!}
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('campaigns.invites.create.button') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>

{!! Form::hidden('type', $type) !!}
