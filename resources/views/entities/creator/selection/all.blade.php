@php
$half = ceil(count($types) / 2);
$i = 0;
@endphp
<div class="title">
    {{ __('entities.creator.titles.everything') }}
</div>
<div class="grid grid-cols-2 selection">
    <div class="column" data-i="{{ $i }}" data-half="{{ $half }}">
    @foreach ($types as $plural => $name)
        @if (!isset($entities[$plural]))
            @continue;
        @endif
        @if ($i == $half) </div><div> @endif
        @include('entities.creator.selection._' . $plural)
        @php $i++; @endphp
    @endforeach
    </div>
</div>
