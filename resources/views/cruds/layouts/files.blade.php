@if (config('entities.file_upload'))
<li class="list-group-item">
    <p class="text-muted">
        <b>{{ trans('crud.fields.files') }}
        @can('update', $model)
            <i class="fa fa-cloud-upload pull-right entity-file-ui" data-url="{{ route('entities.entity_files.index', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('crud.files.actions.manage') }}"></i>
        @endif
        </b>

        @foreach ($model->entity->files as $file)
            <a href="{{ Storage::url($file->path) }}" target="_blank" class="entity-file">
                {{ $file->name }}
            </a>
        @endforeach
    </p>
</li>
@endif