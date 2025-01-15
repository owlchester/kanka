<?php /**
 * @var \App\Models\Entity $entity
 */?>
@php
    $counter = 0;
@endphp
# {!! $entity->name !!}

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

@if (!empty($entity->type))
{{ $entity->type }}
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
@foreach ($entity->pinnedRelations as $relation)
| {{ $relation->relation }} | {{ $relation->target->name }} |
@endforeach
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

## {{ __('crud.tabs.profile') }}
| Name | Content |
|:-|:-|
@if ($entity->hasChild())
    @includeIf('entities.pages.print.profile.' . $entity->entityType->pluralCode(), ['model' => $entity->child])
@endif
@if($entity->hasEntry())
    {!! $converter->convert((string) $entity->entry) !!}
@endif

@foreach ($entity->posts as $post)
@if(!$post->layout_id)
# {!! $post->name !!}
@if(!empty($post->entry))
{!! $converter->convert($post->entry) !!}
@endif
@endif
@endforeach

@can('view-attributes', [$entity, $campaign])
## {{ __('entities/attributes.title') }}

@foreach($entity->starredAttributes() as $attribute)
@if ($attribute->isCheckbox())
@if ($attribute->value)
* **{!! $attribute->name() !!}**: {{ __('general.yes')}}
@else
* **{!! $attribute->name() !!}**: {{ __('general.no')}}
@endif
@elseif ($attribute->isText())
* **{!! $attribute->name() !!}**: {!! nl2br($attribute->mappedValue()) !!}
@elseif (!$attribute->isCheckbox() && !$attribute->isSection())
* **{!! $attribute->name() !!}**: {!! $attribute->mappedValue() !!}
@endif
@endforeach
@endcan
