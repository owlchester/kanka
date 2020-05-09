@if ($entity)
    <a href="{{ route($entity->pluralType() . '.show', $entity->child) }}" class="crud-field-entity"
       data-toggle="tooltip" title="{{ $entity->tooltip() }}">
        <span class="entity-image" style="background-image: url('{{ $entity->child->getImageUrl(40) }}')"></span>
        <span class="entity-name">{{ $entity->name }}</span>
    </a>
@endif
