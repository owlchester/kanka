<a class="entity-image cover-background w-10 h-10"
    style="background-image: url('{{ Avatar::entity($entity)->size($size)->fallback()->thumbnail() }}');"
    title="{{ $title }}"
    href="{{ $entity->url() }}"></a>
