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
--attribute-{{ \Illuminate\Support\Str::slug($attribute->name) }}: {{ trim(preg_replace('/\s+/', ' ', $attribute->value)) }};
        @endforeach
}
    </style>
@endsection

@section('scripts')
    @parent
    <script>
    {!! $plugin->version->javascript !!}
    </script>
    <script>
        const entityData = {
            name: `{{ $entity->name }}`,
            is_private: {{ $entity->is_private ? 'true' : 'false' }},
            type: {
                id: {{ $entity->type_id }},
                code: "{{ $entity->type() }}",
                custom: `{!! \App\Facades\Module::singular($entity->type_id) !!}`,
            },
            attributes: {
@foreach ($entity->allAttributes as $attr)
@if ($attr->isText())
"{{ \Illuminate\Support\Str::slug($attr->name) }}": `{!! $attr->value !!}`,
@else
"{{ \Illuminate\Support\Str::slug($attr->name) }}": `{!! $attr->value !!}`,
@endif

@endforeach
            }
        }
    </script>
@endsection
