<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\OrganisationMember $member
 */
$models = $entity->child->pinnedMembers;
$previousRelation = null;
?>
@foreach ($models as $member)
    @if(!empty($previousRelation) && $previousRelation == $member->role)
    <div class="pinned-member flex gap-2" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <div class="grow text-right">
            @if ($entity->isCharacter() && $member->organisation->entity)
                <x-entity-link
                    :entity="$member->organisation->entity"
                    :campaign="$campaign" />
            @elseif ($member->character && $member->character->entity)
                <x-entity-link
                    :entity="$member->character->entity"
                    :campaign="$campaign" />
            @endif
        </div>
    </div>
    @else
    <div class="pinned-member flex gap-2 flex-wrap" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <strong class="flex-none">
            {{ $member->role }}
        </strong>
        <div class="grow text-right">
            @if ($entity->isCharacter())
                <x-entity-link
                    :entity="$member->organisation->entity"
                    :campaign="$campaign" />
            @else
                <x-entity-link
                    :entity="$member->character->entity"
                    :campaign="$campaign" />
           @endif
        </div>
    </div>
@php $previousRelation = $member->role @endphp
    @endif
@endforeach
