# Entity index

@foreach ($index as $key => $subIndex)
## {!! $key !!}
@foreach($subIndex as $entity)
{{ $entity }}  
@endforeach
@endforeach