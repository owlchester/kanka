

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
                null,
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.entities-with-reminders'
            ) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'element-entry', 'name' => 'entry']) !!}
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
            <label>{{ __('crud.fields.colour') }}</label>
            {!! Form::select('colour', FormCopy::colours(false), (!empty($model) ? null : 'grey'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.visibility')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('crud.fields.position') }}</label>
            {!! Form::number('position', $position ?? null, ['placeholder' => __('timelines/elements.placeholders.position'), 'class' => 'form-control', 'maxlength' => 5]) !!}
        </div>
    </div>
</div>


@include('editors.editor')

@if ($ajax)
    <script type="text/javascript">
        $(document).ready(function () {
            var editorId = 'element-entry';
            // First we remove in case it was already loaded
            tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);
            tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);
            // And add again
            tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);
        });
    </script>
@endif
