<?php

$oldPosition = !empty($model->position) ? $model->position : null;
$positions = [];
if (!empty($era)) {
    $positions = $era->positionOptions(null, true);
    $oldPosition = count($positions);
} elseif (!empty($model)) {
    $positions = $model->era->positionOptions($oldPosition);
}
?>


<x-grid>
    <x-forms.field field="era" css="md:col-span-2" required :label="__('timelines/elements.fields.era')">
        <x-forms.select name="era_id" :options="$timeline->eras->pluck('name', 'id')" :selected="$era->id ?? $source->era_id ?? $model->era_id ?? null" id="element-era-id" />
    </x-forms.field>

    <x-forms.field field="name" :label="__('crud.fields.name')">
        <input type="text" name="name" placeholder="{{ __('timelines/elements.placeholders.name') }}" value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" maxlength="191" />
    </x-forms.field>

    @include('cruds.fields.entity')

    <x-forms.field field="entry" css="md:col-span-2" :label="__('crud.fields.entry')">

        @include('cruds.fields.entry', ['model' => $model])
        <input type="hidden" name="use_entity_entry" value="0" />
        <x-checkbox :text="__('timelines/elements.fields.use_entity_entry')">
            <input type="checkbox" name="use_entity_entry" value="1" @if (old('use_entity_entry', $model->use_entity_entry ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <x-forms.field field="date" :label="__('timelines/elements.fields.date')">
        <input type="text" name="date" value="{{ old('date', $source->date ?? $model->date ?? null) }}" placeholder="{{ __('timelines/elements.placeholders.date') }}" maxlength="45" />
    </x-forms.field>

    <x-forms.field field="event-date" :label="__('timelines/elements.fields.use_event_date')">
        <input type="hidden" name="use_event_date" value="0" />
        <x-checkbox :text="__('timelines/elements.helpers.date')">
            <input type="checkbox" name="use_event_date" value="1" @if (old('use_event_date', $model->use_event_date ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <x-forms.field field="position" :label="__('crud.fields.position')">
        <x-forms.select name="position" :options="$positions" :selected="(!empty($model->position) ? -9999 : $oldPosition)" />
    </x-forms.field>

    @include('cruds.fields.colour', ['default' => 'grey'])

    <x-forms.field field="icon" :label="__('timelines/elements.fields.icon')">

        <input type="text" name="icon" value="{{ old('icon', $source->icon ?? $model->icon ?? null) }}" placeholder="fa-solid fa-gem, ra ra-sword" class="w-full" autocomplete="off" data-paste="fontawesome" list="timeline-element-icon-list" maxlength="45" @if (!$campaign->boosted()) disabled="disabled" @endif />
        <div class="hidden">
            <datalist id="timeline-element-icon-list">
                @foreach (\App\Facades\TimelineElementCache::campaign($campaign)->iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
            <x-helper>
                <p>{!! __('timelines/elements.helpers.icon', [
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" class="text-link">RPG Awesome</a>',
        'fontawesome' => '<a href="' . config('fontawesome.search') . '" class="text-link">Font Awesome</a>'
        ]) !!}</p>
            </x-helper>

        @if (!$campaign->boosted())
            @can('boost', auth()->user())
                <x-helper>
                    <p>
                    <x-icon class="premium" />
                    {!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="' . route('settings.premium', ['campaign' => $campaign]) . '" class="text-link">' . __('concept.premium-campaign') . '</a>']) !!}
                    </p>
                </x-helper>
            @else
                <x-helper>
                    <p>
                    <x-icon class="premium" />
                    {!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaign') . '</a>']) !!}
                    </p>
                </x-helper>
            @endif
        @endif
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field field="collapsed" :label="__('timelines/eras.fields.is_collapsed')">
        <input type="hidden" name="is_collapsed" value="0" />
        <x-checkbox :text="__('timelines/elements.helpers.is_collapsed')">
            <input type="checkbox" name="is_collapsed" value="1" @if (old('is_collapsed', $model->is_collapsed ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
</x-grid>

<input type="hidden" name="era-data-url" data-url="{{ route('timelines.era-list', [$campaign, 'timeline' => $timeline->id, 'timeline_era' => 0, 'new' => !empty($model)]) }}">
<input type="hidden" name="oldPosition" data-url="{{ $oldPosition }}">


@include('editors.editor')

@if (request()->ajax())
    <script type="text/javascript">
        $(document).ready(function () {
@if(auth()->user()->editor != 'legacy')
                window.initSummernote();
@else
                var editorId = 'element-entry';
                // First we remove in case it was already loaded
                tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);
                tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);
                // And add again
                tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);
@endif
        });
    </script>
@endif
