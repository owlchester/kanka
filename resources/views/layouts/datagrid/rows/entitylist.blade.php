@php
$relation = $with[0];
@endphp
<div class="flex flex-wrap gap-1">
@foreach ($model->$relation as $rel)
    <x-entity-link
        :entity="$rel->entity"
        :campaign="$campaign" />
@endforeach
</div>
