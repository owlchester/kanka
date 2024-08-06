@can('relation', [$entity->child, 'add'])
    <a href="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}" class="btn2 btn-sm" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}">
        <x-icon class="plus" />
        <span class="hidden md:inline">
            {{ __('entities.relation') }}
        </span>
    </a>
@endcan
