
@inject('campaign', 'App\Services\CampaignService')

<div class="form-group required">
    <label>{{ __('timelines/elements.fields.era') }}</label>
    {!! Form::select('era_id', $timeline->eras->pluck('name', 'id'), (!empty($eraId) ? $eraId : null), ['class' => 'form-control']) !!}
</div>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('crud.fields.name') }}</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('timelines/elements.placeholders.name')]) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::select2(
                'entity_id',
                (!empty($model) && $model->entity ? $model->entity : null),
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.entities-with-relations'
            ) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'element-entry', 'name' => 'entry']) !!}

    {!! Form::hidden('use_entity_entry', 0) !!}
    <label>
        {!! Form::checkbox('use_entity_entry') !!}
        {{ __('timelines/elements.fields.use_entity_entry') }}
    </label>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('timelines/elements.fields.date') }}</label>
            {!! Form::text('date', null, ['placeholder' => __('timelines/elements.placeholders.date'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('crud.fields.position') }}</label>
            {!! Form::number('position', $position ?? null, ['placeholder' => __('timelines/elements.placeholders.position'), 'class' => 'form-control', 'maxlength' => 5]) !!}
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('crud.fields.colour') }}</label>
            {!! Form::select('colour', FormCopy::colours(false), (!empty($model) ? null : 'grey'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('timelines/elements.fields.icon') }}</label>
            @if ($campaign->campaign()->boosted())
                {!! Form::text('icon', null, ['class' => 'form-control', 'placeholder' => 'fa-solid fa-gem, ra ra-sword']) !!}
                <p class="help-block">{!! __('timelines/elements.helpers.icon', ['rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>', 'fontawesome' => '<a href="https://fontawesome.com/search?m=free&s=solid" target="_blank">Font Awesome</a>']) !!}</p>
            @else
                <p class="help-block">{{ __('crud.errors.boosted') }}</p>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.visibility')
    </div>
    <div class="col-md-6">
        <div class="form-group checkbox">
            <label>
                {!! Form::hidden('is_collapsed', 0) !!}
                {!! Form::checkbox('is_collapsed', 1) !!}
                {{ __('timelines/eras.fields.is_collapsed') }}
            </label>
            <p class="help-block">{{ __('timelines/elements.helpers.is_collapsed') }}</p>
        </div>
    </div>
</div>


@include('editors.editor')

@if ($ajax)
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
