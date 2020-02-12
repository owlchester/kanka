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
        <a href="{{ route('helpers.link') }}" data-toggle="tooltip" title="{{ trans('helpers.link.description') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
    </div>
</div>
