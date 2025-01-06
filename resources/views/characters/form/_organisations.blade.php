<?php
/**
 * @var \App\Models\OrganisationMember $organisation
 * @var \App\Models\Character $model
 */
$organisations = isset($model) ?
    $model->organisationMemberships()->with('organisation')->has('organisation')->orderBy('role', 'ASC')->get() :
    FormCopy::characterOrganisation();
$isAdmin = UserCache::user(auth()->user())->admin();

$singular = App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation'));
$options = [
    '' => __('organisations.members.pinned.none'),
    \App\Models\OrganisationMember::PIN_CHARACTER => \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')),
    \App\Models\OrganisationMember::PIN_ORGANISATION => $singular,
    \App\Models\OrganisationMember::PIN_BOTH => __('organisations.members.pinned.both'),
];
$statuses = [
    \App\Models\OrganisationMember::STATUS_ACTIVE => __('organisations.members.status.active'),
    \App\Models\OrganisationMember::STATUS_INACTIVE => __('organisations.members.status.inactive'),
    \App\Models\OrganisationMember::STATUS_UNKNOWN => __('organisations.members.status.unknown'),
];
?>
<x-grid type="1/1">
    <div class="character-organisations flex flex-col gap-2 md:gap-4">
        @foreach ($organisations as $organisation)
            <div class="flex flex-wrap md:flex-nowrap items-center gap-2 md:gap-2 member-row">
                <div class="field">
                    <select name="organisations[{{ $organisation->id }}]" class="w-full select2" style="width: 100%"
                        data-url="{{ route('search-list', [$this->campaign, config('entities.ids.organisation')] }}"
                        data-placeholder="{{ __('crud.placeholders.organisation') }}"
                        data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                        data-allow-clear="false"
                    >
                        <option value="{{ $organisation->organisation->id }}">{{ $organisation->organisation->name }}</option>
                    </select>
                </div>
                <div class="grow field">
                    <label class="sr-only">{{ __('organisations.members.fields.role') }}</label>
                    <input type="text" name="organisation_roles[{{ $organisation->id }}]" value="{{ $organisation->role }}" placeholder="{{ __('organisations.members.placeholders.role') }}" aria-label="{{ __('organisations.members.placeholders.role') }}" maxlength="191" spellcheck="true"  class="w-full" />
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('organisations.members.fields.status') }}</label>
                    <x-forms.select name="organisation_statuses[{{ $organisation->id }}]" :options="$statuses" :selected="$organisation->status_id ?? null" :label="__('organisations.members.fields.status')" />
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('organisations.members.fields.pinned') }}</label>
                    <x-forms.select name="organisation_pins[{{ $organisation->id }}]" :options="$options" :selected="$organisation->pin_id ?? null" :label="__('organisations.members.fields.pinned')" />
                </div>
                @if ($isAdmin)
                    <div class="text-lg">
                        <input type="hidden" name="organisation_privates[{{ $organisation->id }}]" value="{{ $organisation->is_private }}" />
                        <i class="cursor-pointer hover:text-accent @if($organisation->is_private) fa-solid fa-lock-keyhole @else fa-regular fa-unlock-keyhole @endif" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                    </div>
                @endif
                <div class="flex items-center">
                    <div class="member-delete cursor-pointer hover:text-error text-base-content text-lg" title="{{ __('crud.remove') }}" role="button" tabindex="0" data-target=".member-row">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="btn2 btn-sm" id="add_organisation" href="#">
        <x-icon class="plus" />
        {!! $singular !!}
    </button>
</x-grid>


<input type="hidden" name="character_save_organisations" value="1"/>

@section('modals')
    @parent
    <template id="template_organisation">
        <div class="flex flex-wrap md:flex-nowrap items-center gap-2 md:gap-2 member-row">
            <div class="field">
                <select name="organisations[]" class="w-full tmp-org" style="width: 100%"
                        data-url="{{ route('search-list', [$this->campaign, config('entities.ids.organisation')]) }}"
                        data-placeholder="{{ __('crud.placeholders.organisation') }}"
                        data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                >
                </select>
            </div>
            <div class="grow field">
                <label class="sr-only">{{ __('organisations.members.fields.role') }}</label>
                <input type="text" name="organisation_roles[]" value="" placeholder="{{ __('organisations.members.placeholders.role') }}" aria-label="{{ __('organisations.members.placeholders.role') }}" maxlength="191" spellcheck="true"  class="w-full" />
            </div>
            <div class="field">
                <label class="sr-only">{{ __('organisations.members.fields.status') }}</label>
                <x-forms.select name="organisation_statuses[]" :options="$statuses" :label="__('organisations.members.fields.status')" />
            </div>
            <div class="field">
                <label class="sr-only">{{ __('organisations.members.fields.pinned') }}</label>
                <x-forms.select name="organisation_pins[]" :options="$options" :label="__('organisations.members.fields.pinned')" />
            </div>
            @if ($isAdmin)
                <div class="text-lg">
                    <input type="hidden" name="organisation_privates[]" value="0"/>
                    <i class="fa-regular fa-unlock-keyhole cursor-pointer hover:text-accent " data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                </div>
            @endif
            <div class="text-lg">
                <span class="member-delete cursor-pointer hover:text-error text-base-content" title="{{ __('crud.remove') }}" role="button" tabindex="0" data-target=".parent-row">
                    <x-icon class="trash" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </span>
            </div>
        </div>
    </template>
@endsection

