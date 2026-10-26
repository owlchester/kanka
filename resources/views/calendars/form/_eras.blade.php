<?php /** @var \App\Models\Calendar $model */ ?>
<?php
$eras = old('era_name') ? collect(old('era_name'))->keys()->map(fn ($i) => [
    'name' => old("era_name.{$i}"),
    'suffix' => old("era_suffix.{$i}"),
    'start_year' => old("era_start_year.{$i}"),
    'end_year' => old("era_end_year.{$i}"),
])->all() : ($model->eras ?? []);
?>
<x-grid type="1/1">
    <input type="hidden" name="era_configured" value="1" />
    <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_era" data-target="calendar-eras" title="{{ __('calendars.actions.add_era') }}">
        <x-icon class="plus" /> {{ __('calendars.actions.add_era') }}
    </button>
    <div class="calendar-eras flex flex-col gap-2">
        @foreach ($eras as $era)
            <div class="parent-delete-row grid grid-cols-1 gap-2 md:grid-cols-4">
                <input name="era_name[]" value="{{ $era['name'] ?? '' }}" placeholder="{{ __('calendars.parameters.era.name') }}" aria-label="{{ __('calendars.parameters.era.name') }}" maxlength="191" class="w-full" />
                <input name="era_suffix[]" value="{{ $era['suffix'] ?? '' }}" placeholder="{{ __('calendars.parameters.era.suffix') }}" aria-label="{{ __('calendars.parameters.era.suffix') }}" maxlength="45" class="w-full" />
                <input type="number" name="era_start_year[]" value="{{ $era['start_year'] ?? '' }}" placeholder="{{ __('calendars.parameters.era.start_year') }}" aria-label="{{ __('calendars.parameters.era.start_year') }}" class="w-full" />
                <div class="flex gap-2">
                    <input type="number" name="era_end_year[]" value="{{ $era['end_year'] ?? '' }}" placeholder="{{ __('calendars.parameters.era.end_year') }}" aria-label="{{ __('calendars.parameters.era.end_year') }}" class="w-full" />
                    <button type="button" class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}"><x-icon class="trash" /><span class="sr-only">{{ __('crud.remove') }}</span></button>
                </div>
            </div>
        @endforeach
    </div>
</x-grid>

@section('modals')
    @parent
    <template id="template_era">
        <div class="parent-delete-row grid grid-cols-1 gap-2 md:grid-cols-4">
            <input name="era_name[]" placeholder="{{ __('calendars.parameters.era.name') }}" aria-label="{{ __('calendars.parameters.era.name') }}" maxlength="191" class="w-full" />
            <input name="era_suffix[]" placeholder="{{ __('calendars.parameters.era.suffix') }}" aria-label="{{ __('calendars.parameters.era.suffix') }}" maxlength="45" class="w-full" />
            <input type="number" name="era_start_year[]" placeholder="{{ __('calendars.parameters.era.start_year') }}" aria-label="{{ __('calendars.parameters.era.start_year') }}" class="w-full" />
            <div class="flex gap-2">
                <input type="number" name="era_end_year[]" placeholder="{{ __('calendars.parameters.era.end_year') }}" aria-label="{{ __('calendars.parameters.era.end_year') }}" class="w-full" />
                <button type="button" class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}"><x-icon class="trash" /></button>
            </div>
        </div>
    </template>
@endsection
