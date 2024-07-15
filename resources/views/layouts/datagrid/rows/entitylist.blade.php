
<div class="flex flex-wrap gap-1">
@if (is_array($with))
    @foreach ($model->{$with[0]} as $rel)
        @if (!$rel->{$with[1]}->entity)
            @continue
        @endif
        <x-entity-link
            :entity="$rel->{$with[1]}->entity"
            :campaign="$campaign" />
    @endforeach
@else
    @foreach ($model->$with as $rel)
        @if (!$rel->entity)
            @continue
        @endif
        <x-entity-link
            :entity="$rel->entity"
            :campaign="$campaign" />
    @endforeach
@endif
</div>
