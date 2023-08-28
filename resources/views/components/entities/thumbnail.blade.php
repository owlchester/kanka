<a class="entity-image cover-background"
    style="background-image: url('{{ Avatar::entity($entity)->size($size)->thumbnail() }}');"
    title="{{ $title }}"
    href="{{ $entity->url() }}"></a>
