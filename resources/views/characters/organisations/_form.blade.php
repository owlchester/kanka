@php
$options = [
'' => __('organisations.members.pinned.none'),
\App\Models\OrganisationMember::PIN_CHARACTER => \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')),
\App\Models\OrganisationMember::PIN_ORGANISATION => \App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation')),
\App\Models\OrganisationMember::PIN_BOTH => __('organisations.members.pinned.both'),
];
$statuses = [
    \App\Models\OrganisationMember::STATUS_ACTIVE => __('organisations.members.status.active'),
    \App\Models\OrganisationMember::STATUS_INACTIVE => __('organisations.members.status.inactive'),
    \App\Models\OrganisationMember::STATUS_UNKNOWN => __('organisations.members.status.unknown'),
];

$fromOrg = request()->get('from') === 'org';
@endphp
{{ csrf_field() }}
@if ($fromOrg)
   {!! Form::hidden('organisation_id') !!}
@else
    @include('cruds.fields.organisation', [
        'model' => $member ?? null,
        'allowNew' => false,
        'required' => true,
        'allowClear' => false,
        'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
    ])
@endif

@if ($fromOrg)
    <input type="hidden" name="parent_id" value="" />
    @include('cruds.fields.character', [
        'name' => 'parent_id',
        'preset' => !empty($member) && $member->parent ? $member->parent : null,
        'allowNew' => false,
        'allowClear' => true,
        'label' => __('organisations.members.fields.parent'),
        'placeholder' => __('organisations.members.placeholders.parent'),
        'route' => 'search.organisation-member',
        'model' => $member->organisation,
        'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
    ])
@endif

<div class="field-org-role">
    <label>{{ __('characters.organisations.fields.role') }}</label>
    {!! Form::text('role', null, ['placeholder' => __('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
</div>

<div class="field-org-status">
    <label>
        {{ __('organisations.members.fields.status') }}
    </label>
    {!! Form::select('status_id', $statuses, null, ['class' => 'form-control']) !!}
</div>

<div class="field-org-pinned">
    <label>
        {{ __('organisations.members.fields.pinned') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('organisations.members.helpers.pinned') }}"></i>
    </label>
    {!! Form::select('pin_id', $options, null, ['class' => 'form-control']) !!}
</div>

@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['model' => !empty($member) ? $member : null])


