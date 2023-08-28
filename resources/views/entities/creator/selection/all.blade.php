@php
$half = floor(count($types) / 2);
$i = 0;
@endphp
<div class="text-uppercase text-sm font-bold mb-4">
    {{ __('entities.creator.titles.everything') }}
</div>
<div class="grid grid-cols-2 gap-5 selection">
    <div class="column flex flex-col gap-4" data-i="{{ $i }}" data-half="{{ $half }}">
    @foreach ($types as $plural => $name)
        @if (!isset($entities[$plural]))
            @continue;
        @endif
        @if ($i == $half) </div><div class="column flex flex-col gap-4"> @endif
        @include('entities.creator.selection._' . $plural)
        @php $i++; @endphp
    @endforeach
    </div>
</div>
