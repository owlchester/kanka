<?php
/** @var \App\Models\Entity $connection
 * @var \App\Services\Entity\Connections\RelatedService $connectionService
 */
?>
<h3 class="">
    {{ __('entities/relations.panels.related') }}
</h3>
<x-box class="box-entity-connections" id="entity-related" :padding="false">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th colspan="2">
                    @if(request()->get('order') == 'name' || !request()->has('order'))
                        {{ __('crud.fields.entity') }}
                        <x-icon class="fa-regular fa-arrow-down" />
                    @else
                        <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'table', '#entity-related', 'order' => 'name']) }}">
                            {{ __('crud.fields.name') }}
                        </a>
                    @endif
                </th>
                <th>
                    @if(request()->get('order') == 'type_id')
                        {{ __('crud.fields.entity_type') }}
                        <x-icon class="fa-regular fa-arrow-down" />
                    @else
                        <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'table', '#entity-related', 'order' => 'type_id']) }}">
                            {{ __('crud.fields.entity_type') }}
                        </a>
                    @endif
                </th>
                <th>{{ __('entities/relations.fields.connection') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($connections as $connection)
                <tr data-entity-id="{{ $connection->id }}" data-entity-type="{{ $connection->entityType->code }}">
                    <td class="w-14">
                        <x-entities.thumbnail :entity="$connection" :title="$connection->name"></x-entities.thumbnail>
                    </td>
                    <td>
                        <x-entity-link
                            :entity="$connection"
                            :campaign="$campaign" />

                        @if ($connection->isMap() == 'map')
                            @includeWhen($connection->map->explorable(), 'maps._explore-link', ['map' => $connection->map])
                        @endif
                    </td>
                    <td>
                        {{ $connection->entityType->name() }}
                    </td>
                    <td>
                        {{ $connectionService->connectionsText($connection->id) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($connections->hasPages())
        <div class="text-right">
            {{ $connections->appends(['mode' => $mode, 'order' => request()->get('order')])->fragment('entity-connections')->onEachSide(0)->links() }}
        </div>
    @endif
</x-box>
