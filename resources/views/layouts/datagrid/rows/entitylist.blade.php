@php
$relation = $with;
@endphp
<div class="flex flex-wrap gap-1">
@foreach ($model->$relation as $rel)
    @if (!$rel->entity)
        @continue
    @endif
    <x-entity-link
        :entity="$rel->entity"
        :campaign="$campaign" />
@endforeach
</div>
