{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'organisation_id',
                (!empty($member) && $member->organisation ? $member->organisation : null),
                App\Models\Organisation::class
            ) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.organisations.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => trans('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        @include('cruds.fields.private', ['model' => !empty($member) ? $member : null])
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @if (!$ajax)
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    @endif
</div>
