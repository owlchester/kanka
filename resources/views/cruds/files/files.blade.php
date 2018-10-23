
<h5>{{ __('crud.files.files') }}</h5>

<ul class="list-group list-group-unbordered">
    @foreach ($entity->files as $file)
        <li class="list-group-item">
            <a href="{{ Storage::url($file->link) }}" target="_blank" title="{{ $file->name }}">
                {{ $file->name }}
            </a>
            <i class="fa fa-trash pull-right entity-file-remove" title="{{ __('crud.remove') }}" data-url="{{ route('entities.entity_files.destroy', [$entity, $file]) }}"></i>
        </li>
    @endforeach
</ul>
