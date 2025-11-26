@if ($entity->child->isExtinct())
* {{ __('creatures.hints.is_extinct') }}
@endif
@if ($entity->child->isDead())
* {{ __('creatures.hints.is_dead') }}
@endif