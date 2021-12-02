@php
$options = [
'' => __('organisations.members.pinned.none'),
\App\Models\OrganisationMember::PIN_CHARACTER => __('organisations.members.pinned.character'),
\App\Models\OrganisationMember::PIN_ORGANISATION => __('organisations.members.pinned.organisation'),
\App\Models\OrganisationMember::PIN_BOTH => __('organisations.members.pinned.both'),
];
$statuses = [
    \App\Models\OrganisationMember::STATUS_ACTIVE => __('organisations.members.status.active'),
    \App\Models\OrganisationMember::STATUS_INACTIVE => __('organisations.members.status.inactive'),
    \App\Models\OrganisationMember::STATUS_UNKNOWN => __('organisations.members.status.unknown'),
];
@endphp
{{ csrf_field() }}
<div class="form-group required">
    {!! Form::select2(
        'organisation_id',
        (!empty($member) && $member->organisation ? $member->organisation : null),
        App\Models\Organisation::class
    ) !!}
</div>

<div class="form-group">
    <label>{{ __('characters.organisations.fields.role') }}</label>
    {!! Form::text('role', null, ['placeholder' => __('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
</div>

<div class="form-group">
    <label>
        {{ __('organisations.members.fields.status') }}
    </label>
    {!! Form::select('status_id', $statuses, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>
        {{ __('organisations.members.fields.pinned') }}
        <i class="fas fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('organisations.members.helpers.pinned') }}"></i>
    </label>
    {!! Form::select('pin_id', $options, null, ['class' => 'form-control']) !!}
</div>

@include('cruds.fields.private2', ['model' => !empty($member) ? $member : null])

