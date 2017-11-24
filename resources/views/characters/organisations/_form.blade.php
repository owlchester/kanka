{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('characters.organisations.fields.organisation') }}</label>
            {!! Form::select('organisation_id', (!empty($member) && $member->organisation ? [$member->organisation->id => $member->organisation->name] : []), [],
            ['id' => 'organisation_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
             'data-url' => route('organisations.find'), 'data-placeholder' => trans('characters.organisations.placeholders.organisation')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('characters.organisations.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => trans('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
