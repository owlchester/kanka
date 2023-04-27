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

@include('cruds.fields.character', [
    'required' => true,
    'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
    'allowNew' => false,
    'allowClear' => false,
])
<div class="form-group">
    <input type="hidden" name="parent_id" value="" />

    @include('cruds.fields.character', [
        'label' => __('organisations.members.fields.parent'),
        'placeholder' => __('organisations.members.placeholders.parent'),
        'route' => 'search.organisation-member',
        'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
        'allowNew' => false,
        'allowClear' => false,
    ])
</div>

<div class="form-group">
    <label>{{ __('organisations.members.fields.role') }}</label>
    {!! Form::text('role', null, ['placeholder' => __('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>
                {{ __('organisations.members.fields.status') }}
            </label>
            {!! Form::select('status_id', $statuses, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                {{ __('organisations.members.fields.pinned') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('organisations.members.helpers.pinned') }}"></i>
            </label>
            {!! Form::select('pin_id', $options, null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['model' => !empty($member) ? $member : null])


