<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ trans('crud.panels.entry') }}</h4>
    </div>
    <div class="panel-body editor-panel">
        <div class="form-group">
            {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
        </div>
    </div>
    <div class="panel-footer">
        <a href="//docs.kanka.io/en/latest/features/mentions.html" target="_blank" title="{{ trans('helpers.link.description') }}">{{ __('crud.linking_help') }}</a>
    </div>
</div>
