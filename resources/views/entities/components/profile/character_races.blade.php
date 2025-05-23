@php $existingRaces = []; @endphp
@foreach ($child->characterRaces as $race)
    @if(!empty($existingRaces[$race->race_id]))
        @continue
    @endif
    @php $existingRaces[$race->race_id] = true; @endphp
    <span class="element">
        <x-entity-link
                :entity="$race->race->entity"
                :campaign="$campaign" />
        @if ($race->is_private) <x-icon class="lock" /> @endif
    </span>
@endforeach
