@if ($entity)
    <div class="form-group">
        <label>{{ __('crud.fields.entity') }}</label><br />
        <a href="{{ route($entity->pluralType() . '.show', $entity->child) }}"
           data-toggle="tooltip" title="{{ $entity->tooltip() }}" class="form-control" data-placement="bottom">
            {{ $entity->name }}
        </a>
    </div>
@endif
