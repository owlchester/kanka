<?php
/**
 * @var \App\Models\Plugin $plugin
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\Entity $entity
 * @var \App\Models\MiscModel $model
 */
if (!isset($entity)) {
    $entity = $model->entity;
}
?>

@if ($plugin->version->isDraft())
    <x-alert type="warning" class="max-w-4xl">
        {{ __('This plugin is a draft, meaning only its authors can see it rendered.') }}
    </x-alert>
@endif

<div class="box-entity-attributes" data-plugin="{{ $plugin->id }}" data-version="{{ $plugin->version->id }}">
    <x-character-sheet :plugin="$plugin" :entity="$entity" :campaign="$campaign" />
</div>

@section('styles')
    @parent
    <style>
        {!! $plugin->version->css !!}

        /** Entity attributes **/
        :root {
        @foreach ($entity->allAttributes as $attribute) @if ($attribute->isText()) @continue @endif
--attribute-{{ $attribute->exposedName() }}: {{ trim(preg_replace('/\s+/', ' ', $attribute->value)) }};
        @endforeach
}
    </style>
@endsection

@section('scripts')
    @parent
    <script>
        const entityData = {
            name: `{{ $entity->name }}`,
            is_private: {{ $entity->is_private ? 'true' : 'false' }},
            type: {
                id: {{ $entity->type_id }},
                code: "{{ $entity->entityType->code }}",
                custom: `{!! \App\Facades\Module::singular($entity->type_id) !!}`,
            },
            type_field: `{{ $entity->type }}`,
            attributes: {
@foreach ($entity->allAttributes as $attr)
"{{ $attr->exposedName() }}": `{!! $attr->value !!}`,
@endforeach
            },
@if ($entity->isCharacter() && $entity->child)
            gender: `{{ $entity->child->sex }}`,
            pronouns: `{{ $entity->child->pronouns }}`,
            is_dead: {{ $entity->child->isDead() ? 'true' : 'false' }},
            title: `{{ $entity->child->title }}`,
            age: `{{ $entity->child->age }}`,
            traits: [@foreach ($entity->child->characterTraits as $trait)
            {
                name: `{{ $trait->name }}`,
                entry: `{{ $trait->entry }}`,
                section_id: {{ $trait->section_id }},
                section: '{{ $trait->section_id === 1 ? 'appearance' : 'personality' }}',
            },
            @endforeach ],
            races: [@foreach ($entity->child->characterRaces as $race)
            {
                id: {{ $race->race->id }},
                name: `{{ $race->race->name }}`,
                url: `{{ $race->race->getLink() }}`
            },
            @endforeach ],
            families: [@foreach ($entity->child->characterFamilies as $family)
            {
                id: {{ $family->family->id }},
                name: `{{ $family->family->name }}`,
                url: `{{ $family->family->getLink() }}`
            },
            @endforeach ],
@elseif ($entity->isLocation() && $entity->child)
        is_destroyed: {{ $entity->child->isDestroyed() ? 'true' : 'false' }},
@elseif ($entity->isOrganisation() && $entity->child)
        is_defunct: {{ $entity->child->isDefunct() ? 'true' : 'false' }},
@elseif ($entity->isQuest() && $entity->child)
        is_completed: {{ $entity->child->isCompleted() ? 'true' : 'false' }},
@elseif ($entity->isCreature() && $entity->child)
        is_dead: {{ $entity->child->isDead() ? 'true' : 'false' }},
        is_extinct: {{ $entity->child->isExtinct() ? 'true' : 'false' }},
@elseif (($entity->isRace() || $entity->isFamily()) && $entity->child)
        is_extinct: {{ $entity->child->isExtinct() ? 'true' : 'false' }},
@endif
@if ($entity->hasChild() && $entity->child->location)
            location: {
                id: {{ $entity->child->location->id }},
                name: `{{ $entity->child->location->name }}`,
                url: `{{ $entity->child->location->getLink() }}`
            },
@endif

            tags: [@foreach ($entity->tags as $tag)
            {
                id: {{ $tag->id }},
                name: `{{ $tag->name }}`,
                slug: `{{ $tag->slug }}`,
                url: `{{ $tag->getLink() }}`
            },
            @endforeach ],
        }
        const attributeApis = {
            all: {
                method: 'GET',
                url: '{{ route('entities.attributes.live-api.index', [$campaign, $entity]) }}'
            },
            create: {
                method: 'POST',
                url: '{{ route('entities.attributes.live-api.create', [$campaign, $entity]) }}'
            },
        }
        const abilityApis = {
            all: {
                method: 'GET',
                url: '{{ route('entities.entity_abilities.api', [$campaign, $entity]) }}'
            },
        }
    </script>
    <script>
        {!! $plugin->version->javascript !!}
    </script>
@endsection
