<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */
?>
@if(!$campaign->boosted() || !$widget->showMembers($entity))
    @php return @endphp
@endif

@php
$child = null;
if (isset($model)) {
    $child = $model;
} else {
    $child = $entity->child;
}
$members = $entity->typeId() == config('entities.ids.family')
    ? $child->members()->orderBy('name')->get()
    : $child->members()->with(['character', 'character.entity'])->get()
;
@endphp

<div class="widget-advanced-members">

@if($entity->typeId() == config('entities.ids.family'))
    <ul class="list-group">
        @foreach ($members as $member)
        <li class="list-group-item">{!! $member->tooltipedLink() !!}
        @endforeach
    </ul>
@else
    <dl class="dl-horizontal">
        @foreach ($members as $member)
            @if (empty($member->character))
                @continue
            @endif
            <dt>{{ $member->role }}</dt>
            <dd>{!! $member->character->tooltipedLink() !!}</dd>
        @endforeach
    </dl>
@endif

</div>
