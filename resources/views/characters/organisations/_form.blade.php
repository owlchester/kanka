@php
$options = [
    '' => __('organisations.members.pinned.none'),
    App\Enums\OrganisationMemberPin::character->value => App\Facades\Module::singular(
        config('entities.ids.character'),
        __('entities.character')
    ),
    App\Enums\OrganisationMemberPin::organisation->value => App\Facades\Module::singular(
        config('entities.ids.organisation'),
        __('entities.organisation')
    ),
    App\Enums\OrganisationMemberPin::both->value => __('organisations.members.pinned.both'),
];
$statuses = [
    App\Enums\OrganisationMemberStatus::active->value => __('organisations.members.status.active'),
    App\Enums\OrganisationMemberStatus::inactive->value => __('organisations.members.status.inactive'),
    App\Enums\OrganisationMemberStatus::unknown->value => __('organisations.members.status.unknown'),
];
$fromOrg = request()->get('from') === 'org';
@endphp
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('organisations.members.edit.helper', ['name' => $model->name]) !!}</p>
    </x-helper>

@if ($fromOrg)
        <input type="hidden" name="organisation_id" value="{{ $member->organisation_id }}" />
@else
    @include('cruds.fields.organisation', [
        'model' => $member ?? null,
        'allowNew' => false,
        'required' => true,
        'allowClear' => false,
        'dropdownParent' => $dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null),
    ])
@endif

@if ($fromOrg)
    <input type="hidden" name="parent_id" value="" />
    @include('cruds.fields.character', [
        'name' => 'parent_id',
        'preset' => $member->parent ?? null,
        'allowNew' => false,
        'allowClear' => true,
        'label' => __('organisations.members.fields.parent'),
        'placeholder' => __('organisations.members.placeholders.parent'),
        'route' => 'search.organisation-member',
        'model' => $member->organisation,
        'dropdownParent' => $dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null),
    ])
@endif
    <x-forms.field
        field="org-role"
        :label="__('characters.organisations.fields.role')">
        <input type="text" name="role" value="{{ old('role', $source->role ?? $member->role ?? null) }}" maxlength="45" class="w-full" placeholder="{{ __('organisations.members.placeholders.role') }}" />
    </x-forms.field>

    <x-forms.field
        field="org-status"
        :label="__('organisations.members.fields.status')">
        <x-forms.select name="status_id" :options="$statuses" :selected="$member->status_id ?? null" />
    </x-forms.field>

    <x-forms.field
        field="org-pinned"
        :label="__('organisations.members.fields.pinned')"
        :helper="__('organisations.members.helpers.pinned')"
        tooltip>
        <x-forms.select name="pin_id" :options="$options" :selected="$member->pin_id ?? null" />
    </x-forms.field>

    @includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['model' => $member ?? null])
</x-grid>


