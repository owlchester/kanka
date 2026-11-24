@php
    $memberships = isset($model)
        ? $model->organisationMemberships()->with('organisation.entity')->has('organisation')->orderBy('role')->get()
        : FormCopy::characterOrganisation();
    $isAdmin = auth()->user()->can('admin', $campaign);
    $singular = App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation'));
    $plural = App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'));
    $characterLabel = App\Facades\Module::singular(config('entities.ids.character'), __('entities.character'));
    $options = [
        '' => __('organisations.members.pinned.none'),
        App\Enums\OrganisationMemberPin::character->value => __('characters.organisations.form.profile', ['module' => $characterLabel]),
        App\Enums\OrganisationMemberPin::organisation->value => __('characters.organisations.form.profile', ['module' => $singular]),
        App\Enums\OrganisationMemberPin::both->value => __('organisations.members.pinned.both'),
    ];
    $statuses = [
        App\Enums\OrganisationMemberStatus::active->value => __('organisations.members.status.active'),
        App\Enums\OrganisationMemberStatus::inactive->value => __('organisations.members.status.inactive'),
        App\Enums\OrganisationMemberStatus::unknown->value => __('organisations.members.status.unknown'),
    ];
    $rows = $memberships->filter(fn ($membership) => $membership->organisation?->entity)->mapWithKeys(fn ($membership) => [
        $membership->id => [
            'organisation_id' => $membership->organisation_id,
            'name' => $membership->organisation->entity->name,
            'role' => $membership->role,
            'status' => $membership->status_id?->value ?? 0,
            'pin' => $membership->pin_id?->value ?? '',
            'private' => $membership->is_private,
        ],
    ]);
    if (old('character_save_organisations')) {
        $oldOrganisations = collect(old('organisations', []));
        $organisationNames = App\Models\Organisation::where('campaign_id', $campaign->id)
            ->whereIn('id', $oldOrganisations->filter()->values())->with('entity')->get()->keyBy('id');
        $rows = $oldOrganisations->map(fn ($id, $key) => [
            'organisation_id' => $id,
            'name' => $organisationNames->get($id)?->entity?->name ?? '',
            'role' => old("organisation_roles.$key", ''),
            'status' => old("organisation_statuses.$key", 0),
            'pin' => old("organisation_pins.$key", ''),
            'private' => old("organisation_privates.$key", false),
        ]);
    }
    $blankRow = ['organisation_id' => '', 'name' => '', 'role' => '', 'status' => 0, 'pin' => '', 'private' => false];
@endphp

<section class="flex flex-col gap-4" aria-labelledby="character-memberships-heading" data-character-memberships>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div class="flex flex-col gap-1">
            <h3 id="character-memberships-heading" class="text-lg font-semibold">{{ __('characters.organisations.form.title', ['organisations' => $plural]) }}</h3>
            <p class="text-sm text-neutral-content">{{ __('characters.organisations.form.helper', ['organisations' => $plural]) }}</p>
        </div>
        <button type="button" class="btn2 btn-sm btn-outline" data-add-organisation>
            <x-icon class="plus" />
            {{ __('characters.organisations.form.add', ['organisation' => $singular]) }}
        </button>
    </div>

    <div class="rounded-lg border border-base-300 bg-base-200 p-6 text-center {{ $rows->isNotEmpty() ? 'hidden' : '' }}" data-membership-empty>
        <x-icon class="fa-regular fa-building text-2xl text-neutral-content" />
        <p class="mt-2 font-medium">{{ __('characters.organisations.form.empty_title') }}</p>
        <p class="mt-1 text-sm text-neutral-content">{{ __('characters.organisations.form.empty', ['organisations' => $plural]) }}</p>
    </div>

    <div class="character-organisations flex flex-col gap-4">
        @foreach ($rows as $key => $row)
            @include('characters.form._organisation', ['key' => $key, 'row' => $row, 'isTemplate' => false])
        @endforeach
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <button type="button" class="btn2 btn-sm btn-outline {{ $rows->isEmpty() ? 'hidden' : '' }}" data-add-organisation data-membership-bottom-add>
            <x-icon class="plus" />
            {{ __('characters.organisations.form.add', ['organisation' => $singular]) }}
        </button>
        <p class="text-xs text-neutral-content">{{ __('characters.organisations.form.save_hint') }}</p>
    </div>
    <span class="sr-only" aria-live="polite" data-membership-announcement></span>
    <input type="hidden" name="character_save_organisations" value="1" />
    <template id="template_organisation">
        @include('characters.form._organisation', ['key' => '__MEMBERSHIP__', 'row' => $blankRow, 'isTemplate' => true])
    </template>
</section>
