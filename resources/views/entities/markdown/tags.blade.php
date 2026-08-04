@php($tag = $entity->child)

@if ($tag->hasColour())
- **{!! __('crud.fields.colour') !!}:** {!! $tag->colour !!}
@endif
@if ($tag->hasIcon())
- **{!! __('tags.fields.icon') !!}:** {!! $tag->icon !!}
@endif
