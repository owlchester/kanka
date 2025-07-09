<?php /** @var \App\Models\QuestElement[] $elements */?>
@php $count = 0; @endphp

<div class="" id="quest-elements">
    <x-grid>
    @foreach ($elements as $element)
        @if ($element->entity_id && !$element->entity)
            @continue
        @endif
        @php $count++; @endphp
            @include('quests.elements._element')
    @endforeach
    </x-grid>
</div>

{!! $elements->fragment('quest-elements')->links() !!}
