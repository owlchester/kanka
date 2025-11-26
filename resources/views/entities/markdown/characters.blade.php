@if (!empty($entity->child->title))
* {{ $entity->child->title }}
@endif

@if (!empty($entity->child->age))
* {{ $entity->child->age }}
@endif

@if (!empty($entity->child->sex))
* {{ $entity->child->sex }}
@endif

@if ($entity->child->pronouns)
* {{ $entity->child->pronouns }}
@endif

@if ($entity->child->isDead())
* {{ __('characters.hints.is_dead') }}
@endif

@if (!empty($entity->child->title))
* {{ $entity->child->title }}
@endif
