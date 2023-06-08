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

@inject('campaignService', 'App\Services\CampaignService')

<x-grid>

    <div class="field-era col-span-2 required">
        <label>{{ __('timelines/elements.fields.era') }}</label>
        {!! Form::select('era_id', $timeline->eras->pluck('name', 'id'), (!empty($eraId) ? $eraId : null), ['class' => 'form-control', 'id' => 'era-form-add']) !!}
    </div>

    <div class="field-name mb-0">
        <label>{{ __('crud.fields.name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('timelines/elements.placeholders.name')]) !!}
    </div>

    @include('cruds.fields.entity')

    <div class="field-entry col-span-2">
        <label>{{ __('crud.fields.entry') }}</label>
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'element-entry', 'name' => 'entry']) !!}

        {!! Form::hidden('use_entity_entry', 0) !!}
        <label>
            {!! Form::checkbox('use_entity_entry') !!}
            {{ __('timelines/elements.fields.use_entity_entry') }}
        </label>
    </div>

    <div class="field-date">
        <label>{{ __('timelines/elements.fields.date') }}</label>
        {!! Form::text('date', null, ['placeholder' => __('timelines/elements.placeholders.date'), 'class' => 'form-control', 'maxlength' => 45]) !!}
    </div>
    <div class="field-event-date">
        {!! Form::hidden('use_event_date', 0) !!}
        <label>
            {!! Form::checkbox('use_event_date') !!}
            {{ __('timelines/elements.fields.use_event_date') }}
            <i class="fa-solid fa-question-circle" data-toggle="tooltip" title="{{ __('timelines/elements.helpers.date') }}" aria-hidden="true"></i>
        </label>
    </div>
    <div class="field-position">
        <label>{{ __('crud.fields.position') }}</label>
        {!! Form::select('position', $positions, (!empty($model->position) ? -9999 : $oldPosition), ['class' => 'form-control', 'name' => 'position']) !!}
    </div>

    <div class="field-colour">
        <label>{{ __('crud.fields.colour') }}</label>
        {!! Form::select('colour', FormCopy::colours(false), (!empty($model) ? null : 'grey'), ['class' => 'form-control select2-colour']) !!}
    </div>

    <div class="field-icon">
        <label>{{ __('timelines/elements.fields.icon') }}</label>
        {!! Form::text(
            'icon',
            null,
            ['class' => 'form-control',
                'placeholder' => 'fa-solid fa-gem, ra ra-sword',
                ($campaignService->campaign()->boosted() ? null : 'disabled'),
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

        @if (!$campaignService->campaign()->boosted())
            @subscriber()
                <p class="help-block">
                    <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('settings.premium', __('concept.premium-campaigns'), ['campaign' => $campaignService->campaign()])]) !!}
                </p>
            @else
                <p class="help-block">
                    <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.premium', __('concept.premium-campaign'))]) !!}
                </p>
            @endsubscriber
        @endif
    </div>

    @include('cruds.fields.visibility_id')

    <div class="field-collapsed checkbox">
        <label>
            {!! Form::hidden('is_collapsed', 0) !!}
            {!! Form::checkbox('is_collapsed', 1) !!}
            {{ __('timelines/eras.fields.is_collapsed') }}
        </label>
        <p class="help-block">{{ __('timelines/elements.helpers.is_collapsed') }}</p>
    </div>
</x-grid>

<input type="hidden" name="era-data-url" data-url="{{ route('timelines.era-list', ['timeline' => $timeline->id, 'timeline_era' => 0, 'new' => !empty($model)]) }}">
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
