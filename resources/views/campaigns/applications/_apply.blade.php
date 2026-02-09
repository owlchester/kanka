<x-grid type="1/1">
    @include('partials.errors')

    <p class="text-neutral-content m-0">{{ __('campaigns/applications.apply.help') }}</p>

    <x-forms.field 
        field="character_concept" 
        :label="__('campaigns/applications.fields.character_concept')">
        <textarea 
            name="character_concept" 
            class="w-full p-2 border rounded" 
            rows="5" 
            placeholder="{{ __('campaigns/applications.placeholders.character_concept') }}"
        >{{ old('character_concept', $application->character_concept ?? '') }}</textarea>
    </x-forms.field>

    <x-forms.field
        field="experience"
        required
        :label="__('campaigns/applications.fields.experience_level')"
        :helper="__('campaigns/applications.helpers.experience_level')">
        
        <x-forms.select 
            name="experience" 
            radio 
            :options="[
                0 => __('campaigns/applications.experience.new'),
                1 => __('campaigns/applications.experience.intermediate'),
                2 => __('campaigns/applications.experience.veteran'),
            ]" 
            :selected="old('experience', $application->experience ?? 0)" 
        />
    </x-forms.field>

    <div class="col-span-full space-y-4 mt-4">
        <h3 class="text-lg font-medium text-gray-900">{{ __('campaigns/applications.headers.availability') }}</h3>
        
        <x-forms.field 
            field="availability_days" 
            :label="__('campaigns/applications.fields.availability_days')"
            :helper="__('campaigns/applications.helpers.availability_days')">
            
            <div class="flex flex-wrap gap-4 mt-2">
                @foreach(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $day)
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="availability_days[]" 
                            value="{{ $day }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm"
                            @checked(in_array($day, old('availability_days', $application->availability_days ?? [])))
                        >
                        <span class="ml-2 text-sm text-gray-600">{{ __('campaigns/applications.weekdays.' . $day) }}</span>
                    </label>
                @endforeach
            </div>
        </x-forms.field>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-forms.field field="time_start" :label="__('campaigns/applications.fields.time_start')">
                <input 
                    type="time" 
                    name="time_start" 
                    class="w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('time_start', isset($application->time_start) ? \Carbon\Carbon::parse($application->time_start)->format('H:i') : '') }}" 
                />
            </x-forms.field>

            <x-forms.field field="time_end" :label="__('campaigns/applications.fields.time_end')">
                <input 
                    type="time" 
                    name="time_end" 
                    class="w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('time_end', isset($application->time_end) ? \Carbon\Carbon::parse($application->time_end)->format('H:i') : '') }}" 
                />
            </x-forms.field>

            {{-- Timezone (Usually kept as campaign default unless user overrides) --}}
            <x-forms.field field="timezone" :label="__('campaigns/applications.fields.timezone')">
                <x-forms.select 
                    name="timezone" 
                    :options="$timezones" 
                    :selected="old('timezone', $application->timezone ?? $campaign->getFilter(\App\Enums\CampaignFilterType::Timezone))" 
                />
            </x-forms.field>
        </div>
    </div>

    <div class="col-span-full mt-6 space-y-6">
        <h3 class="text-lg font-medium text-gray-900">{{ __('campaigns/applications.headers.preferences') }}</h3>
        <x-forms.field field="pref_rp_combat" :label="__('campaigns/applications.fields.pref_rp_combat')">
            <div class="flex justify-between text-xs font-medium opacity-80 mb-1">
                <span>{{ __('campaigns/applications.labels.rp_heavy') }}</span>
                <span>{{ __('campaigns/applications.labels.combat_focused') }}</span>
            </div>
            <input 
                type="range" 
                name="pref_rp_combat" 
                min="0" max="2" step="1" 
                value="{{ old('pref_rp_combat', $application->pref_rp_combat ?? 1) }}"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
            >
        </x-forms.field>

        <x-forms.field field="pref_tone" :label="__('campaigns/applications.fields.pref_tone')">
            <div class="flex justify-between text-xs font-medium opacity-80 mb-1">
                <span>{{ __('campaigns/applications.labels.serious') }}</span>
                <span>{{ __('campaigns/applications.labels.casual') }}</span>
            </div>
            <input 
                type="range" 
                name="pref_tone" 
                min="0" max="2" step="1" 
                value="{{ old('pref_tone', $application->pref_tone ?? 1) }}"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
            >
        </x-forms.field>
    </div>

    <x-forms.field 
        field="external_link" 
        :label="__('campaigns/applications.fields.external_link')"
        :helper="__('campaigns/applications.helpers.external_link')">
        <input 
            type="url" 
            name="external_link" 
            placeholder="https://dndbeyond.com/characters/..." 
            class="w-full border-gray-300 rounded-md shadow-sm"
            value="{{ old('external_link', $application->external_link ?? '') }}"
        />
    </x-forms.field>

    <x-forms.field 
        field="additional_notes" 
        :label="__('campaigns/applications.fields.additional_notes')">
        <input 
            type="text" 
            name="additional_notes" 
            placeholder="{{ __('campaigns/applications.placeholders.additional_notes') }}" 
            class="w-full border-gray-300 rounded-md shadow-sm"
            value="{{ old('additional_notes', $application->additional_notes ?? '') }}"
            maxlength="255"
        />
    </x-forms.field>
</x-grid>
