@php
$statuses = [
    App\Enums\OrganisationMemberStatus::active->value => __('organisations.members.status.active'),
    App\Enums\OrganisationMemberStatus::inactive->value => __('organisations.members.status.inactive'),
    App\Enums\OrganisationMemberStatus::unknown->value => __('organisations.members.status.unknown'),
];
$pins = [
    App\Enums\OrganisationMemberPin::empty->value => __('organisations.members.pinned.none'),
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
@endphp
<x-grid type="1/1">
    <x-forms.field field="role" :label="__('organisations.members.fields.role')">
        <input type="text" name="role" value="" placeholder="{{ __('organisations.members.placeholders.role') }}" maxlength="45" class="w-full" />
    </x-forms.field>
    <x-forms.field field="status_id" :label="__('organisations.members.fields.status')">
        <select name="status_id" class="w-full">
            <option value="" selected="selected"></option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </x-forms.field>
    <x-forms.field field="pin_id" :label="__('organisations.members.fields.pinned')">
        <select name="pin_id" class="w-full">
            <option value="" selected="selected"></option>
            @foreach ($pins as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </x-forms.field>
</x-grid>
