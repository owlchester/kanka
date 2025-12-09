@foreach ($entity->files as $file)
    <a href="{{ Storage::url($file->path) }}" target="_blank" class="entity-file text-link">
        {{ $file->name }}
    </a>
@endforeach
