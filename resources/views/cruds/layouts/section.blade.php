@if ($campaign->enabled('sections') && $model->section)
    <li class="list-group-item">
        <b>{{ trans('crud.fields.section') }}</b>
        <span  class="pull-right">
            <a href="{{ route('sections.show', $model->section->id) }}" data-toggle="tooltip" title="{{ $model->section->tooltip() }}">{{ $model->section->name }}</a>
            @if ($model->section->section)
                , <a href="{{ route('sections.show', $model->section->section->id) }}" data-toggle="tooltip" title="{{ $model->section->section->tooltip() }}">{{ $model->section->section->name }}</a>
            @endif
        </span>
        <br class="clear" />
    </li>
@endif