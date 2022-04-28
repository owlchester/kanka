<?php
/**
 * @var \App\Models\Tag $model
 */
$allMembers = true;
$addEntityUrl = route('tags.entity-add', $model);
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('tag_id')) {
    $datagridOptions['tag_id'] = (int) $model->id;
    $allMembers = true;
}

$existing = $model->allChildren()->count();
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
            @if (request()->has('tag_id'))
                <a href="{{ route('tags.show', [$model, '#tag-children']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allChildren()->count() }})
                </a>
            @else
                <a href="{{ route('tags.show', [$model, 'tag_id' => $model->id, '#tag-children']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->entities()->count() }})
                </a>
            @endif

            @if ($existing > 0)
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
            @endif
        </div>
    </div>

    @if ($existing === 0)
        <div class="box-body">
        <p class="help-block">
            {{ __('tags.helpers.no_children') }}
        </p>
        @can('update', $model)
            <a href="{{ $addEntityUrl }}" class="btn btn-primary"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
            </a>
        @endcan
        </div>
    @else
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('tags.children', $datagridOptions)])
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
