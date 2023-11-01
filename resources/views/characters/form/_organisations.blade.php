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
    <div class="character-organisations flex flex-col gap-5">
        @foreach ($organisations as $organisation)
            <div class="flex flex-wrap md:flex-no-wrap items-start gap-2 md:gap-2 member-row">
                <div class="field">
                    <select name="organisations[{{ $organisation->id }}]" class="w-full select2" style="width: 100%"
                        data-url="{{ route('organisations.find', $campaign) }}"
                        data-placeholder="{{ __('crud.placeholders.organisation') }}"
                        data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                        data-allow-clear="false"
                    >
                        <option value="{{ $organisation->organisation->id }}">{{ $organisation->organisation->name }}</option>
                    </select>
                </div>
                <div class="grow field">
                    <label class="sr-only">{{ __('organisations.members.fields.role') }}</label>
                    {!! Form::text('organisation_roles[' . $organisation->id . ']', $organisation->role, [
                        'class' => 'w-full',
                        'placeholder' => __('organisations.members.placeholders.role'),
                        'spellcheck' => 'true',
                        'aria-label' => __('organisations.members.fields.role'),
                    ]) !!}
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('organisations.members.fields.status') }}</label>
                    {!! Form::select('organisation_statuses[' . $organisation->id . ']', $statuses, $organisation->status_id, ['class' => 'w-full', 'aria-label' => __('organisations.members.fields.status')]) !!}
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('organisations.members.fields.pinned') }}</label>
                    {!! Form::select('organisation_pins[' . $organisation->id . ']', $options, $organisation->pin_id, ['class' => 'w-full', 'aria-label' => __('organisations.members.fields.pinned')]) !!}
                </div>
                @if ($isAdmin)
                    <div class="">
                        {!! Form::hidden('organisation_privates[' . $organisation->id . ']', $organisation->is_private) !!}
                        <i class="fa-solid @if($organisation->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                    </div>
                @endif
                <div class="">
                    <span class="member-delete btn2 btn-sm btn-error btn-outline" title="{{ __('crud.remove') }}" role="button" tabindex="0" data-target=".member-row">
                        <x-icon class="trash"></x-icon>
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <button class="btn2 btn-sm" id="add_organisation" href="#">
        <x-icon class="plus"></x-icon>
        {!! $singular !!}
    </button>
</x-grid>


{!! Form::hidden('character_save_organisations', 1) !!}

@section('modals')
    @parent
    <template id="template_organisation">
        <div class="flex flex-wrap md:flex-no-wrap items-start gap-2 md:gap-2 member-row">
            <div class="field">
                <select name="organisations[]" class="w-full tmp-org" style="width: 100%"
                        data-url="{{ route('organisations.find', $campaign) }}"
                        data-placeholder="{{ __('crud.placeholders.organisation') }}"
                        data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                >
                </select>
            </div>
            <div class="grow field">
                <label class="sr-only">{{ __('organisations.members.fields.role') }}</label>
                {!! Form::text('organisation_roles[]', null, [
                    'class' => 'w-full',
                    'placeholder' => __('organisations.members.placeholders.role'),
                    'spellcheck' => 'true',
                    'aria-label' => __('organisations.members.fields.role'),
                ]) !!}
            </div>
            <div class="field">
                <label class="sr-only">{{ __('organisations.members.fields.status') }}</label>
                {!! Form::select('organisation_statuses[]', $statuses, null, ['class' => 'w-full', 'aria-label' => __('organisations.members.fields.status')]) !!}
            </div>
            <div class="field">
                <label class="sr-only">{{ __('organisations.members.fields.pinned') }}</label>
                {!! Form::select('organisation_pins[]', $options, null, ['class' => 'w-full', 'aria-label' => __('organisations.members.fields.pinned')]) !!}
            </div>
            @if ($isAdmin)
                <div class="">
                    {!! Form::hidden('organisation_privates[]', 0) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                </div>
            @endif
            <div class="">
                <span class="member-delete btn2 btn-sm btn-error btn-outline" title="{{ __('crud.remove') }}" role="button" tabindex="0" data-target=".member-row">
                    <x-icon class="trash"></x-icon>
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </span>
            </div>
        </div>
    </template>
@endsection

