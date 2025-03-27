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
@endphp

<x-grid type="1/1">

    @empty($member)
        <x-helper>
            {{ __('organisations.members.create.helper', ['name' => $model->name]) }}
        </x-helper>
    @endif

        @include('cruds.fields.characters', ['quickCreator' => false, 'required' => true])

    <div>
        <input type="hidden" name="parent_id" value="" />

        @include('cruds.fields.character', [
            'name' => 'parent_id',
            'label' => __('organisations.members.fields.parent'),
            'placeholder' => __('organisations.members.placeholders.parent'),
            'route' => 'search.organisation-member',
            'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
            'allowNew' => false,
            'allowClear' => false,
        ])
    </div>

    <x-forms.field field="role" :label="__('organisations.members.fields.role')">
        <input type="text" name="role" value="{{ old('role', $model->role ?? null) }}" placeholder="{{ __('organisations.members.placeholders.role') }}" maxlength="45" />
    </x-forms.field>
    <x-forms.field field="status" :label="__('organisations.members.fields.status')">
        <x-forms.select name="status_id" :options="$statuses" :selected="$model->status_id ?? null" />
    </x-forms.field>

    <x-forms.field field="pinned" :label="__('organisations.members.fields.pinned')" :helper="__('organisations.members.helpers.pinned')" tooltip>
        <x-forms.select name="pin_id" :options="$options" :selected="$model->pin_id ?? null" />
    </x-forms.field>
</x-grid>


@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['model' => !empty($member) ? $member : null])


