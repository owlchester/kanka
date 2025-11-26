@php
use Illuminate\Support\Str;
@endphp
# {!! __('export.index') !!}

@foreach ($index as $key => $subIndex)
## {!! Str::beforeLast($key, '_') !!}
@foreach($subIndex as $entity)
{{ $entity }}
@endforeach
@endforeach