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
        const entityData = window.entityData = {
            name: {{ \Illuminate\Support\Js::from($entity->name) }},
            is_private: {{ \Illuminate\Support\Js::from((bool) $entity->is_private) }},
            type: {
                id: {{ \Illuminate\Support\Js::from($entity->type_id) }},
                code: {{ \Illuminate\Support\Js::from($entity->entityType->code) }},
                custom: {{ \Illuminate\Support\Js::from(\App\Facades\Module::singular($entity->type_id)) }},
            },
            type_field: {{ \Illuminate\Support\Js::from($entity->type) }},
            attributes: {
@foreach ($entity->allAttributes as $attr)
                {{ \Illuminate\Support\Js::from($attr->exposedName()) }}: {{ \Illuminate\Support\Js::from($attr->value) }},
@endforeach
            },
@if ($entity->isCharacter() && $entity->child)
            gender: {{ \Illuminate\Support\Js::from($entity->child->sex) }},
            pronouns: {{ \Illuminate\Support\Js::from($entity->child->pronouns) }},
            title: {{ \Illuminate\Support\Js::from($entity->child->title) }},
            age: {{ \Illuminate\Support\Js::from($entity->child->age) }},
            traits: [@foreach ($entity->child->characterTraits as $trait)
            {
                name: {{ \Illuminate\Support\Js::from($trait->name) }},
                entry: {{ \Illuminate\Support\Js::from($trait->entry) }},
                section_id: {{ \Illuminate\Support\Js::from($trait->section_id) }},
                section: {{ \Illuminate\Support\Js::from($trait->section_id === 1 ? 'appearance' : 'personality') }},
            },
            @endforeach ],
            races: [@foreach ($entity->child->characterRaces as $race)
            {
                id: {{ \Illuminate\Support\Js::from($race->race->id) }},
                name: {{ \Illuminate\Support\Js::from($race->race->entity->name) }},
                url: {{ \Illuminate\Support\Js::from(route('entities.show', [$campaign, $race->race->entity])) }}
            },
            @endforeach ],
            families: [@foreach ($entity->child->characterFamilies as $family)
            {
                id: {{ \Illuminate\Support\Js::from($family->family->id) }},
                name: {{ \Illuminate\Support\Js::from($family->family->entity->name) }},
                url: {{ \Illuminate\Support\Js::from(route('entities.show', [$campaign, $family->family->entity])) }}
            },
            @endforeach ],
@endif
@if ($entity->status)
            status: {{ \Illuminate\Support\Js::from($entity->status->key) }},
@endif
@if ($entity->hasChild() && $entity->child->location)
            location: {
                id: {{ \Illuminate\Support\Js::from($entity->child->location->id) }},
                name: {{ \Illuminate\Support\Js::from($entity->child->location->entity->name) }},
                url: {{ \Illuminate\Support\Js::from(route('entities.show', [$campaign, $entity->child->location->entity])) }}
            },
@endif

            tags: [@foreach ($entity->tags as $tag)
            {
                id: {{ \Illuminate\Support\Js::from($tag->id) }},
                name: {{ \Illuminate\Support\Js::from($tag->entity->name) }},
                slug: {{ \Illuminate\Support\Js::from($tag->slug) }},
                url: {{ \Illuminate\Support\Js::from(route('entities.show', [$campaign, $tag->entity])) }}
            },
            @endforeach ],
        }
        const attributeApis = window.attributeApis = {
            all: {
                method: 'GET',
                url: {{ \Illuminate\Support\Js::from(route('entities.attributes.live-api.index', [$campaign, $entity])) }}
            },
            create: {
                method: 'POST',
                url: {{ \Illuminate\Support\Js::from(route('entities.attributes.live-api.create', [$campaign, $entity])) }}
            },
        }
        const abilityApis = window.abilityApis = {
            all: {
                method: 'GET',
                url: {{ \Illuminate\Support\Js::from(route('entities.entity_abilities.api', [$campaign, $entity])) }}
            },
        }
    </script>
    <script>
        {!! $plugin->version->javascript !!}
    </script>
@endsection
