<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\OrganisationMember $member
 */
$models = $model->pinnedMembers();
$previousRelation = null;

if (count($models) === 0) {
    return;
}
?>
@foreach ($models as $member)
    @if(!empty($previousRelation) && $previousRelation == $member->role)
    <li class="list-group-item list-group-item-repeat pinned-member" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <span class="pull-right">
            @if ($model instanceof \App\Models\Character)
                {!! $member->organisation->tooltipedLink() !!}
            @else
                {!! $member->character->tooltipedLink() !!}
            @endif
        </span>
        <br class="clear" />
    </li>
    @else
    <li class="list-group-item pinned-member" data-character="{{ $member->character_id }}" data-organisation="{{ $member->organisation_id }}" data-role="{{ $member->role }}" data-private="{{ $member->is_private }}">
        <strong>
            {{ $member->role }}
        </strong>
        <span class="pull-right">
            @if ($model instanceof \App\Models\Character)
                {!! $member->organisation->tooltipedLink() !!}
            @else
                {!! $member->character->tooltipedLink() !!}
           @endif
        </span>
        <br class="clear" />
@php $previousRelation = $member->role @endphp
    @endif
@endforeach
