<?php
/** @var \App\Models\Entity $connection
 * @var \App\Services\Entity\ConnectionService $connectionService
 */
?>
<div class="box box-solid box-entity-connections" id="entity-connections">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('entities/relations.panels.connections') }}
        </h2>

        <table class="table table-hover">
            <thead>
            <tr>
                <th class="avatar"></th>
                <th>{{ __('crud.fields.name') }}</th>
                <th>{{ __('crud.fields.entity_type') }}</th>
                <th>{{ __('entities/relations.fields.connection') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($connections as $connection)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $connection->child->getImageUrl(40) }}');" title="{{ $connection->name }}" href="{{ $connection->url() }}"></a>

                    </td>
                    <td>
                        {!! $connection->child->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ __('entities.' . $connection->child->getEntityType()) }}
                    </td>
                    <td>
                        {{ $connectionService->connectionsText($connection->id) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $connections->appends(['mode' => $mode])->fragment('entity-connections')->links() }}

    </div>
</div>
