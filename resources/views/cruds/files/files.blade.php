<h5>{{ __('crud.files.files') }}</h5>

<ul class="list-group list-group-unbordered">
    @foreach ($entity->files as $file)
        <li class="list-group-item">
            <a href="{{ Storage::url($file->path) }}" target="_blank" title="{{ $file->name }}">{{ $file->name }}</a>
            <input type="text" class="entity-file-name" style="display: none;" data-url="{{ route('entities.entity_files.update', [$entity, $file]) }}" />
            <i class="fa fa-trash pull-right entity-file-remove" title="{{ __('crud.remove') }}" data-url="{{ route('entities.entity_files.destroy', [$entity, $file]) }}"></i>
            <i class="fa fa-pencil pull-right entity-file-rename margin-r-5" title="{{ __('crud.rename') }}" data-default="{{ $file->name }}"></i>

            <p class="text-red entity-file-error" style="display:none"></p>
        </li>
    @endforeach
</ul>

<p class="text-muted">{{ __('crud.files.hints.limit', ['max' => config('entities.max_entity_files')]) }}</p>