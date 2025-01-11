@php
$half = floor(count($entityTypes)  / 2);
$i = 0;
@endphp
<div class="text-uppercase text-sm font-bold mb-4">
    {{ __('entities.creator.titles.everything') }}
</div>
<div class="grid grid-cols-2 gap-5 selection">
    <div class="column flex flex-col gap-4 sm:w-60" data-i="{{ $i }}" data-half="{{ $half }}">
    @foreach ($entityTypes as $entityType)
        @if ($i == $half) </div><div class="column flex flex-col gap-4  sm:w-60"> @endif
        <div class="option flex gap-2">
            @if ($entityType instanceof \App\Models\EntityType)
                @include('entities.creator.selection._main')
                @include('entities.creator.selection._full')
            @else
                <a href="#" class="quick-creator-selection flex gap-2 overflow-hidden items-center" data-toggle="entity-creator" data-url="{{ route('entity-creator.post', [$campaign]) }}" data-entity-type="post}">
                    <x-icon class="w-4 text-center fa-duotone fa-pen" />
                    <span class="overflow-hidden">{!! __('entities.post') !!}</span>
                </a>
            @endif
        </div>
        @php $i++; @endphp
    @endforeach
    </div>
</div>
