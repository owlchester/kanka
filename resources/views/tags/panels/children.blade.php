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
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
            @if (!$allMembers)
                <a href="{{ route('tags.show', [$model, 'all_members' => true, '#tag-children']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allChildren()->acl()->count() }})
                </a>
            @else
                <a href="{{ route('tags.show', [$model, '#tag-children']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->entities()->acl()->count() }})
                </a>
            @endif

            @if ($r->count() > 0)
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
            @endif
        </div>
    </div>
    <div class="box-body">
        @if ($r->count() === 0)
            <p class="help-block">
                {{ __('tags.helpers.no_children') }}
            </p>
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        @else
        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#tag-children'])
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
                <tr data-entity-id="{{ $child->id }}" data-entity-type="{{ $child->type() }}" class="@if ($child->is_private) entity-private @endif">
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
        @endif
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('tag-children')->links() }}
        </div>
    @endif
</div>


@section('modals')
    @parent
    <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('crud.actions.help') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('tags.hints.children') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
