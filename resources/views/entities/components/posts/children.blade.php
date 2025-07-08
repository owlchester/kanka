

@if($entity->hasChild())
    @php
        // Get the name
        $type = class_basename($entity->child);

        // Construct the layout class path.
        $layoutClass = "\\App\\Renderers\\Layouts\\{$type}\\{$type}";

        // Get table name from the model
        $table = $entity->child->getTable();

        // Make the route name.
        $route = $table . '.' . $table;

        Datagrid::layout($layoutClass)
            ->route($route, ['campaign' => $campaign, strtolower($type) => $entity->child]);

        $rows = $entity->child
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType', 'entity.visibleTags',
                'parent', 'parent.entity',
            ])
            ->paginate(config('limits.pagination'));
        $rows->withPath(route($route, ['campaign' => $campaign, strtolower($type) => $entity->child]));

    @endphp
@else

    @php
        $layout = app()->make(App\Renderers\Layouts\Entity\Children::class);
        $layout->entityType($entity->entityType);
        Datagrid::layout($layout)
            ->route('entities.children', ['campaign' => $campaign, 'entity' =>  $entity]);

        $rows = $entity
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'image', 'entityType',
                'visibleTags',
                'children',
                'parent',
            ])
            ->paginate(config('limits.pagination'));
        $rows->withPath(route('entities.children', ['campaign' => $campaign, 'entity' =>  $entity]));
    @endphp
@endif
<div class="overflow-x-auto" id="entity-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
    <x-dialog id="edit-dialog" :loading="true" />
@endsection
