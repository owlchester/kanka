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
**{!! __('crud.fields.type') !!}:** {{ $entity->type }}
@endif

@if ($entity->tags->count() > 0)
{{ $entityData['tags'] }}
@endif
**{!! __('crud.fields.visibility') !!}:** {!! $entity->is_private ? __('campaigns/visibilities.titles.private') : __('campaigns/visibilities.titles.public') !!}

@if($entity->hasEntry())
---
## {!! __('crud.fields.entry') !!}
{!! $converter->convert((string) $entity->entry) !!}

---

@endif
@if ($entity->tooltip || $entity->is_template || $entity->archived_at)
### {!! __('entities.notes') !!}
@endif
@if ($entity->tooltip)
* {!! __('crud.fields.tooltip') !!}: {!! strip_tags($entity->tooltip) !!}
@endif
@if ($entity->is_template)
* {!! __('crud.fields.template') !!}: Yes
@endif
@if ($entity->archived_at)
* {!! __('crud.fields.archived') !!}: Yes
@endif

@if (!empty($entityData['attributes']))
## {!! __('crud.tabs.attributes') !!}

{{ $entityData['attributes'] }}  

@endif

@if (!empty($entityData['relations']))
## {!! __('crud.tabs.connections') !!}

{{ $entityData['relations'] }}  

@endif

@includeWhen($entity->isCharacter(), 'entities.markdown.characters')
@includeWhen($entity->isQuest(), 'entities.markdown.quests')
@includeWhen($entity->isOrganisation(), 'entities.markdown.organisations')
@includeWhen($entity->isLocation(), 'entities.markdown.locations')
@includeWhen($entity->isCreature(), 'entities.markdown.creatures')
@includeWhen($entity->isRace(), 'entities.markdown.races')
@includeWhen($entity->isFamily(), 'entities.markdown.families')

@if ($entity->hasPins())
## {{ __('entities/pins.title') }}

| {!! __('crud.fields.name') !!} | {!! __('export.content') !!} |
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
