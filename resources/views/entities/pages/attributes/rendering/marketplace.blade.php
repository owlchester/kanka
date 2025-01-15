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
    <x-alert type="info" class="max-w-4xl">
        {{ __('This plugin is a draft, meaning only its authors can see it rendered.') }}
    </x-alert>
@endif

<x-box css="box-entity-attributes">
    <div class="marketplace-template-{{ $plugin->plugin->uuid }}">
        {!! $plugin->version->content($entity) !!}
    </div>
</x-box>

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
            attributes: {
@foreach ($entity->allAttributes as $attr)
"{{ $attr->exposedName() }}": `{!! $attr->value !!}`,
@endforeach
            },
@if ($entity->child instanceof \App\Models\Character)
            type_field: `{{ $entity->child->type }}`,
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
            @endif
            @if ($entity->child->location)
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
