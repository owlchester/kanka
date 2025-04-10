@php $existingFamilies = []; @endphp
@foreach ($child->characterFamilies as $family)
    @if(!empty($existingFamilies[$family->family_id]))
        @continue
    @endif
    @php $existingFamilies[$family->family_id] = true; @endphp
    <span class="element">
                    <x-entity-link
                        :entity="$family->family->entity"
                        :campaign="$campaign" />
                </span>
    @if ($family->is_private) <x-icon class="lock" /> @endif
@endforeach
