<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */?>
@php
    $counter = 0;
@endphp
# {!! $entity->name !!}

@if ($model instanceof \App\Models\Character && $model->isDead())
{{ __('characters.hints.is_dead') }}
@endif
@if ($model instanceof \App\Models\Quest && $model->isCompleted())
{{ __('quests.fields.is_completed') }}
@endif
@if ($model instanceof \App\Models\Organisation && $model->isDefunct())
{{ __('organisations.hints.is_defunct') }}
@endif
@if ($model instanceof \App\Models\Location && $model->isDestroyed())
{{ __('locations.hints.is_destroyed') }}
@endif
@if ($model instanceof \App\Models\Creature && $model->isExtinct())
{{ __('creatures.hints.is_extinct') }}
@endif
@if ($model instanceof \App\Models\Race && $model->isExtinct())
{{ __('races.hints.is_extinct') }}
@endif
@if ($model instanceof \App\Models\Creature && $model->isDead())
{{ __('creatures.hints.is_dead') }}
@endif
@if ($model instanceof \App\Models\Family && $model->isExtinct())
{{ __('families.hints.is_extinct') }}
@endif

@if ($model instanceof \App\Models\Character && !empty($model->title))
{{ $model->title }}
@endif

@if (!empty($model->type))
{{ $model->type }}
@endif

@if ($entity->hasPins())
## {{ __('entities/pins.title') }}

| Name | Content |
|:-|:-|
@if(!$entity->pinnedFiles->isEmpty())
@foreach ($model->entity->pinnedFiles as $asset)
| {{ $asset->name }} | {!! Storage::url($asset->metadata['path']) !!} |
@endforeach
@endif
@if(!$entity->pinnedAliases->isEmpty())
| {{ __('entities/assets.actions.alias') }} | @foreach ($model->entity->pinnedAliases as $asset) {{ $asset->name }}@if ($counter < $model->entity->pinnedAliases->count() - 1)@php $counter++; @endphp, @endif @endforeach |@endif
@foreach ($entity->pinnedRelations as $relation)
| {{ $relation->relation }} | {{ $relation->target->name }} |
@endforeach
@if(method_exists($model, 'pinnedMembers') && !$model->pinnedMembers->isEmpty())
@foreach ($model->pinnedMembers as $member)
@if ($model instanceof \App\Models\Character)
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
@includeIf('entities.pages.print.profile.' . $model->getTable())

@if($model->hasEntry())
{!! $converter->convert((string) $model->entry) !!}
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
