<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\OrganisationMember $member
 */
$models = $model->pinnedMembers;
$previousRelation = null;
?>
@foreach ($models as $member)
    @if(!empty($previousRelation) && $previousRelation == $member->role)
    <div class="pinned-member flex gap-2" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <div class="grow text-right">
            @if ($model instanceof \App\Models\Character)
                {!! $member->organisation->tooltipedLink() !!}
            @else
                {!! $member->character->tooltipedLink() !!}
            @endif
        </div>
    </div>
    @else
    <div class="pinned-member flex gap-2 flex-wrap" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <strong class="flex-none">
            {{ $member->role }}
        </strong>
        <div class="grow text-right">
            @if ($model instanceof \App\Models\Character)
                {!! $member->organisation->tooltipedLink() !!}
            @else
                {!! $member->character->tooltipedLink() !!}
           @endif
        </div>
    </div>
@php $previousRelation = $member->role @endphp
    @endif
@endforeach
