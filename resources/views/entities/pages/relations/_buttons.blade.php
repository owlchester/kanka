@can('relation', [$entity->child, 'add'])
    <a href="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}" class="btn2 btn-sm btn-accent" data-toggle="dialog" data-target="connection-dialog" data-url="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}">
        <x-icon class="plus"></x-icon>
        <span class="hidden-xs hidden-sm">
            {{ __('entities.relation') }}
        </span>
    </a>
@endcan
