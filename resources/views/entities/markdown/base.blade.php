<?php /**
 * @var \App\Models\Entity $entity
 */?>

@if ($entity->image)
![avatar]({!! $entity->image->url() !!})
@endif
@if ($entity->header)
![header]({!! $entity->header->getUrl(480, 270) !!})
@endif

# {!! html_entity_decode($entity->name, ENT_QUOTES, 'UTF-8') !!}

@if ($entity->type)
**{!! __('crud.fields.type') !!}:** {!! html_entity_decode($entity->type, ENT_QUOTES, 'UTF-8') !!}
@endif
@if ($entity->tags->count() > 0)
**{!! __('entities.tags') !!}:** {!! implode(', ', $entityData['tags']) !!}
@endif
**{!! __('crud.fields.visibility') !!}:** {!! $entity->is_private ? __('campaigns/visibilities.titles.private') : __('campaigns/visibilities.titles.public') !!}

@if($entity->hasEntry())
---
## {!! __('fields.description.label') !!}
{!! $converter->convert((string) $entityData['entry']) !!}

---

@endif
@if ($entity->is_template || $entity->archived_at)
### {!! __('entities.notes') !!}
@endif
@if ($entity->is_template)
* {!! __('crud.fields.template') !!}: Yes
@endif
@if ($entity->archived_at)
* {!! __('crud.fields.archived') !!}: Yes
@endif

@if (!empty($entityData['attributes']))
## {!! __('entries/tabs.properties') !!}

{!! $entityData['attributes'] !!}

@endif
@if (!empty($entityData['relations']))
## {!! __('entries/tabs.relations') !!}

{!! $entityData['relations'] !!}

@endif
@includeWhen($entity->isCharacter(), 'entities.markdown.characters')
@includeWhen($entity->isQuest(), 'entities.markdown.quests')
@includeWhen($entity->isOrganisation(), 'entities.markdown.organisations')
@includeWhen($entity->isLocation(), 'entities.markdown.locations')
@includeWhen($entity->isCreature(), 'entities.markdown.creatures')
@includeWhen($entity->isRace(), 'entities.markdown.races')
@includeWhen($entity->isFamily(), 'entities.markdown.families')

@if ($entity->hasPins())
## {!! __('entities/pins.title') !!}

| {!! __('crud.fields.name') !!} | {!! __('export.content') !!} |
|:-|:-|
@if(!$entity->pinnedFiles->isEmpty())
@foreach ($entity->pinnedFiles as $asset)
| {!! $asset->name !!} | {!! $asset->url() !!} |
@endforeach
@endif
@if(!$entity->pinnedAliases->isEmpty())
| {!! __('entities/assets.actions.alias') !!} | {!! implode(', ', $entityData['pinnedAliases']) !!} |
@endif
@if($entity->hasChild() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty())
@foreach ($entity->child->pinnedMembers as $member)
@if ($member instanceof \App\Models\Character)
| {!! $member->organisation->name !!} | {!! $member->role !!} |
@else
| {!! $member->character->name !!} | {!! $member->role !!} |
@endif
@endforeach
@endif
@endif

@foreach ($entity->posts as $post)
@if(isset($entityData['posts'][$post->id]))
## {!! $post->name !!}
{!! $converter->convert($entityData['posts'][$post->id]) !!}
@endif
@endforeach
