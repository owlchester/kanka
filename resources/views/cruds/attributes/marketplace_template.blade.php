<?php
/**
 * @var \App\Models\Plugin $plugin
 * @var \App\Models\Attribute $attribute
 */
?>

@if ($plugin->version->isDraft())
    <div class="row">
        <div class="col-md-6 col-xs-12">

            <div class="alert alert-info">
                {{ __('This plugin is a draft, meaning only its authors can see it rendered.') }}
            </div>
        </div>
    </div>
@endif

<div class="marketplace-template-{{ $plugin->plugin->uuid }}">
    {!! $plugin->version->content(isset($entity) ? $entity : $model->entity) !!}
</div>

@section('styles')
    @parent
    <style>
        {!! $plugin->version->css !!}

        /** Entity attributes **/
        :root {
        @foreach ((isset($entity) ? $entity->allAttributes : $model->entity->allAttributes) as $attribute) @if ($attribute->isText()) @continue @endif
--attribute-{{ \Illuminate\Support\Str::slug($attribute->name) }}: {{ trim(preg_replace('/\s+/', ' ', $attribute->value)) }};
        @endforeach
}
    </style>
@endsection
