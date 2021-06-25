{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'character_id',
                (!empty($member) && $member->character ? $member->character : null),
                App\Models\Character::class
            ) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('organisations.members.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => trans('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        @include('cruds.fields.private', ['model' => !empty($member) ? $member : null])
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @includeWhen(!request()->ajax(), 'partials.or_cancel')
</div>

