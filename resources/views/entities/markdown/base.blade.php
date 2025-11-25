<?php /**
 * @var \App\Models\Entity $entity
 */?>
@php
    $counter = 0;
@endphp

@if ($entity->image)
![avatar]({!! $entity->image->url() !!})
@endif
@if ($entity->header)
![header]('{!! $entity->header->getUrl(480, 270) !!}')
@endif

# {!! $entity->name !!}

@if ($entity->type)
**type:** {{ $entity->type }}

@endif
@if ($entity->tags->count() > 0)
{{ $entityData['tags']}}

@endif
**visibility:** {{ $entity->is_private ? 'Private' : 'Public' }}

@if($entity->hasEntry())
---
## Entry
{!! $converter->convert((string) $entity->entry) !!}
---

@endif

### Notes
@if ($entity->tooltip)
* Tooltip: {!! strip_tags($entity->tooltip) !!}

@endif

@if ($entity->is_template)
* Template: Yes

@endif

@if ($entity->archived_at)
* Archived: Yes

@endif

@if (!empty($entityData['attributes']))
## Attributes

{{ $entityData['attributes'] }}  

@endif

@if (!empty($entityData['relations']))
## Relations

{{ $entityData['relations'] }}  

@endif
@if (!$entity->entityType->isCustom())
## Profile
@endif

@if ($entity->isCharacter() && $entity->child->isDead())
{{ __('characters.hints.is_dead') }}
@endif
@if ($entity->isQuest() && $entity->child->isCompleted())
{{ __('quests.fields.is_completed') }}
@endif
@if ($entity->isOrganisation() && $entity->child->isDefunct())
{{ __('organisations.hints.is_defunct') }}
@endif
@if ($entity->isLocation() && $entity->child->isDestroyed())
{{ __('locations.hints.is_destroyed') }}
@endif
@if ($entity->isCreature() && $entity->child->isExtinct())
{{ __('creatures.hints.is_extinct') }}
@endif
@if ($entity->isRace() && $entity->child->isExtinct())
{{ __('races.hints.is_extinct') }}
@endif
@if ($entity->isCreature() && $entity->child->isDead())
{{ __('creatures.hints.is_dead') }}
@endif
@if ($entity->isFamily() && $entity->child->isExtinct())
{{ __('families.hints.is_extinct') }}
@endif

@if ($entity->isCharacter() && !empty($entity->child->title))
{{ $entity->child->title }}
@endif

@if ($entity->hasPins())
## {{ __('entities/pins.title') }}

| Name | Content |
|:-|:-|
@if(!$entity->pinnedFiles->isEmpty())
@foreach ($entity->pinnedFiles as $asset)
| {{ $asset->name }} | {!! $asset->url() !!} |
@endforeach
@endif
@if(!$entity->pinnedAliases->isEmpty())
| {{ __('entities/assets.actions.alias') }} | @foreach ($entity->pinnedAliases as $asset) {{ $asset->name }}@if ($counter < $entity->pinnedAliases->count() - 1)@php $counter++; @endphp, @endif @endforeach |@endif

@if($entity->hasChild() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty())
@foreach ($entity->child->pinnedMembers as $member)
@if ($member instanceof \App\Models\Character)
| {{ $member->organisation->name }} | {{ $member->role }} |
@else
| {{ $member->character->name }} | {{ $member->role }} |
@endif
@endforeach
@endif
@endif

@foreach ($entity->posts as $post)
@if(!$post->layout_id)
## {!! $post->name !!}
@if(!empty($post->entry))
{!! $converter->convert($post->entry) !!}
@endif
@endif
@endforeach
