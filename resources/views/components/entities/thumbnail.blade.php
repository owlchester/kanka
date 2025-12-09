<a class="entity-image overflow-hidden rounded-full w-10 h-10"
    title="{{ $title }}"
    href="{{ $entity->url() }}">
    <img alt="{{ $title }}" loading="lazy" src="{{ Avatar::entity($entity)->size($size)->fallback()->thumbnail() }}" />
</a>
