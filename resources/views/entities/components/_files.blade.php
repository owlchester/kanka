@foreach ($entity->files as $file)
    <a href="{{ Storage::url($file->path) }}" target="_blank" class="entity-file">
        {{ $file->name }}
    </a>
@endforeach