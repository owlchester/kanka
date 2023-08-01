<a class="btn2 btn-sm" href="{{ route('entities.attributes.template', $entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $entity) }}">
    <i class="fa-solid fa-copy" aria-hidden="true"></i>
    {{ __('entities/attributes.actions.apply_template') }}
</a>

<a href="{{ route('entities.attributes.edit', ['entity' => $entity]) }}" class="btn2 btn-sm btn-accent">
    <i class="fa-solid fa-list" aria-hidden="true"></i>
    {{ __('entities/attributes.actions.manage') }}
</a>
