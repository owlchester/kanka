{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('campaigns.invites.fields.email') }}:</label>
            {!! Form::text('email', null, ['placeholder' => trans('campaigns.invites.placeholders.email'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('campaigns.invites.create.button') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
