@if ($entity->child->isDead() || !empty($entity->child->title) || !empty($entity->child->age) || !empty($entity->child->sex) || !empty($entity->child->pronouns))
## {!! __('crud.tabs.profile') !!}
@endif

@if (!empty($entity->child->title))
* **{!! __('characters.fields.title') !!}:** {!! $entity->child->title !!}
@endif
@if (!empty($entity->child->age))
* **{!! __('characters.fields.age') !!}:** {!! $entity->child->age !!}
@endif
@if (!empty($entity->child->sex))
* **{!! __('characters.fields.sex') !!}:** {!! $entity->child->sex !!}
@endif
@if (!empty($entity->child->pronouns))
* **{!! __('characters.fields.pronouns') !!}:** {!! $entity->child->pronouns !!}
@endif
@if ($entity->child->isDead())
* {!! __('characters.hints.is_dead') !!}

@endif
@if ($entity->child->characterTraits->count() > 0)
@foreach ($entity->child->characterTraits->groupBy('section_id') as $sectionId => $traits)
### {!! $sectionId == App\Models\CharacterTrait::SECTION_APPEARANCE ? __('characters.sections.appearance') : __('characters.sections.personality') !!}

@foreach ($traits as $trait)
* {!! $trait->name !!}@if($sectionId == App\Models\CharacterTrait::SECTION_APPEARANCE): {!! $trait->entry !!}@endif  
@endforeach

@endforeach
@endif