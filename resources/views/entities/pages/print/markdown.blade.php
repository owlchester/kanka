<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */?>

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
@if ($model instanceof \App\Models\Creature && $model->isExtinct())
    {{ __('creatures.hints.is_extinct') }}
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
| {{ __('entities/assets.actions.alias') }} | |
@foreach ($model->entity->pinnedAliases as $asset)
| {{ $asset->name }} | |
@endforeach
@endif 
@foreach ($entity->pinnedRelations as $relation)
| {{ $relation->relation }} | {!! $converter->convert($relation->target->tooltipedLink()) !!} |
@endforeach
@if(method_exists($model, 'pinnedMembers') && !$model->pinnedMembers->isEmpty())
@foreach ($model->pinnedMembers as $member)
@if ($model instanceof \App\Models\Character)
| {!! $converter->convert($member->organisation->tooltipedLink()) !!} | {{ $member->role }} |
@else
| {!! $converter->convert($member->character->tooltipedLink()) !!} | {{ $member->role }} |
@endif
@endforeach
@endif
@endif

{!! $model->getTable() !!}

## {{ __('crud.tabs.profile') }}
| Name | Content |
|:-|:-|
@includeIf('entities.pages.print.profile.' . $model->getTable())


{!! $converter->convert($model->entry) !!}            

@foreach ($entity->posts as $post)
@if(!$post->layout_id)
# {!! $post->name !!}
@if($post->entry)
{!! $converter->convert($post->entry) !!}
@endif
@endif
@endforeach

@if($entity->accessAttributes())
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
@endif