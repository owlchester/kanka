{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('campaigns.roles.fields.name') }}</label>
            {!! Form::select('user_id', $campaign->membersList($role->users->pluck('user_id')->toArray()), null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @includeWhen(!request()->ajax(), 'partials.or_cancel')
</div>
