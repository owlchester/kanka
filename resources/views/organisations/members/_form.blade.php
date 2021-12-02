@php
$options = [
    '' => __('organisations.members.pinned.none'),
    \App\Models\OrganisationMember::PIN_CHARACTER => __('organisations.members.pinned.character'),
    \App\Models\OrganisationMember::PIN_ORGANISATION => __('organisations.members.pinned.organisation'),
    \App\Models\OrganisationMember::PIN_BOTH => __('organisations.members.pinned.both'),
];
@endphp

{{ csrf_field() }}
<div class="form-group required">
    {!! Form::select2(
        'character_id',
        (!empty($member) && $member->character ? $member->character : null),
        App\Models\Character::class
    ) !!}
</div>
<div class="form-group">
    <label>{{ __('organisations.members.fields.role') }}</label>
    {!! Form::text('role', null, ['placeholder' => __('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
</div>

<div class="form-group">
    <label>
        {{ __('organisations.members.fields.pinned') }}
        <i class="fas fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('organisations.members.helpers.pinned') }}"></i>
    </label>
    {!! Form::select('pin_id', $options, null, ['class' => 'form-control']) !!}
</div>



@include('cruds.fields.private2', ['model' => !empty($member) ? $member : null])


