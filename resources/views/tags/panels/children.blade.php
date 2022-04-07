<?php
/**
 * @var \App\Models\Tag $model
 * @var \App\Models\Entity[] $r
 */
$filters = [];
$r = null;
$addEntityUrl = route('tags.entity-add', $model);

$datagridSorter = new \App\Datagrids\Sorters\TagChildrenSorter();
$datagridSorter->request(request()->all());

$filters = [];
$allMembers = true;
if (!request()->has('all_members')) {
    $filters['tag_id'] = $model->id;
    $allMembers = false;
}

if ($allMembers) {
    $r = $model->allChildren();
} else {
    $r = $model->entities();
}
$r = $r->acl()
    ->simpleSort($datagridSorter)
    ->paginate();

?>
<div class="box box-solid" id="tag-children">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('tags.show.tabs.children') }}
        </h3>
        <div class="box-tools">
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        </div>
    </div>
    <div class="box-body">

        <p class="help-block">
            {{ __('tags.hints.children') }}
        </p>

        <div class="row">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#tag-children'])
            </div>
            <div class="col-md-6 text-right">
                @if (!$allMembers)
                    <a href="{{ route('tags.show', [$model, 'all_members' => true, '#tag-children']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allChildren()->acl()->count() }})
                    </a>
                @else
                    <a href="{{ route('tags.show', [$model, '#tag-children']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->entities()->acl()->count() }})
                    </a>
                @endif
            </div>
        </div>
        <table id="section-children" class="table table-hover">
            <thead>
            <tr>
                <th class="avatar"><br /></th>
                <th>{{ __('crud.fields.name') }}</th>
                <th>{{ __('crud.fields.entity_type') }}</th>
                <th class="text-right">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($r as $child)
                <tr data-entity-id="{{ $child->id }}" data-entity-type="{{ $child->type() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $child->avatar(true) }}');" title="{{ $child->name }}" href="{{ $child->url() }}"></a>
                    </td>
                    <td>
                        @if ($child->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $child->tooltipedLink() !!}
                    </td>
                    <td colspan="2">
                        {{ __('entities.' . $child->pluralType()) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('tag-children')->links() }}
    </div>
</div>
