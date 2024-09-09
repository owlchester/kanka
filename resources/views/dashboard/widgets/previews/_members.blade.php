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
$members = $entity->isFamily()
    ? $child->members()->with('entity')->orderBy('name')->get()
    : $child->members()->with(['character', 'character.entity'])
        ->leftJoin('characters', 'characters.id', '=', 'organisation_member.character_id')
        ->orderBy('characters.name')
        ->get();
@endphp

<div class="widget-advanced-members mt-5">

@if($entity->isFamily())
    <div class="flex flex-col gap-2 members">
<?php /** @var \App\Models\CharacterFamily $member */?>
        @foreach ($members as $member)
            @if (empty($member->entity)) @continue @endif
            <div class="">
                <x-entity-link
                    :entity="$member->entity"
                    :campaign="$campaign" />
            </div>
        @endforeach
    </div>
@else
    <div class="flex flex-col gap-2 members">
<?php /** @var \App\Models\OrganisationMember $member */?>
        @foreach ($members as $member)
            @if (empty($member->character)) @continue @endif
            <div class="grid grid-cols-2 gap-2 members" data-role="{{ Illuminate\Support\Str::slug($member->role) }}"  data-status="{{ $member->status_id }}">
                <div class="font-extrabold">{{ $member->role }}</div>
                <div>
                    <x-entity-link
                        :entity="$member->character->entity"
                        :campaign="$campaign" />
                </div>
            </div>
        @endforeach
    </div>
@endif

</div>
