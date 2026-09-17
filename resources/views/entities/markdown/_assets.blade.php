## {!! __('entities/files.fields.files') !!} & {!! __('entities/pins.links') !!}

@foreach ($entityData['assets'] as $asset)
@if (!$asset['pinned'])
* **{!! $asset['name'] !!}**: @if ($asset['url']) [{{ $asset['type'] === 'file' ? __('entities/files.fields.file') : __('entities/pins.links') }}]({!! $asset['url'] !!}) @else {!! __('crud.history.unknown') !!} @endif
{!! "\n" !!}
@endif
@endforeach
