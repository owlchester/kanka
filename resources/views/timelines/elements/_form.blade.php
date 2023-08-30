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

    <x-forms.field field="era" css="col-span-2" :required="true" :label="__('timelines/elements.fields.era')">
        {!! Form::select('era_id', $timeline->eras->pluck('name', 'id'), (!empty($eraId) ? $eraId : null), ['class' => 'form-control', 'id' => 'element-era-id']) !!}
    </x-forms.field>

    <x-forms.field field="name" :label="__('crud.fields.name')">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('timelines/elements.placeholders.name')]) !!}
    </x-forms.field>

    @include('cruds.fields.entity')

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'element-entry', 'name' => 'entry']) !!}
        {!! Form::hidden('use_entity_entry', 0) !!}
        <label>
            {!! Form::checkbox('use_entity_entry') !!}
            {{ __('timelines/elements.fields.use_entity_entry') }}
        </label>
    </x-forms.field>

    <x-forms.field field="date" :label="__('timelines/elements.fields.date')">
        {!! Form::text('date', null, ['placeholder' => __('timelines/elements.placeholders.date'), 'class' => 'form-control', 'maxlength' => 45]) !!}
    </x-forms.field>

    <x-forms.field field="event-date" :label="__('timelines/elements.fields.use_event_date')">
        {!! Form::hidden('use_event_date', 0) !!}
        <label>
            {!! Form::checkbox('use_event_date') !!}
            {{ __('timelines/elements.helpers.date') }}
        </label>
    </x-forms.field>

    <x-forms.field field="position" :label="__('crud.fields.position')">
        {!! Form::select('position', $positions, (!empty($model->position) ? -9999 : $oldPosition), ['class' => 'form-control', 'name' => 'position']) !!}
    </x-forms.field>

    <x-forms.field field="colour" :label="__('crud.fields.colour')">
        {!! Form::select('colour', FormCopy::colours(false), (!empty($model) ? null : 'grey'), ['class' => 'form-control select2-colour']) !!}
    </x-forms.field>

    <x-forms.field field="icon" :label="__('timelines/elements.fields.icon')">
        {!! Form::text(
            'icon',
            null,
            ['class' => 'form-control',
                'placeholder' => 'fa-solid fa-gem, ra ra-sword',
                ($campaign->boosted() ? null : 'disabled'),
                'list' => 'timeline-element-icon-list',
                'autocomplete' => 'off',
                'data-paste' => 'fontawesome',
            ])
        !!}
        <div class="hidden">
            <datalist id="timeline-element-icon-list">
                @foreach (\App\Facades\TimelineElementCache::iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
            <p class="help-block">{!! __('timelines/elements.helpers.icon', [
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>',
        'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">Font Awesome</a>'
        ]) !!}</p>

        @if (!$campaign->boosted())
            @subscriber()
                <p class="help-block">
                    <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('settings.premium', __('concept.premium-campaigns'), ['campaign' => $campaign])]) !!}
                </p>
            @else
                <p class="help-block">
                    <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </p>
            @endsubscriber
        @endif
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field field="collapsed" :label="__('timelines/eras.fields.is_collapsed')">
        {!! Form::hidden('is_collapsed', 0) !!}
        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_collapsed', 1) !!}
            <span>{{ __('timelines/elements.helpers.is_collapsed') }}</span>
        </label>
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
