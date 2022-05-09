<?php
/** @var \App\Models\Tag $model*/
$filters = [];
if (request()->has('tag_id')) {
    $filters['tag_id'] = request()->get('tag_id');
}
?>
<div class="box box-solid" id="tag-tags">
    <div class="box-header">

        <h3 class="box-title">
            {{ __('tags.show.tabs.tags') }}
        </h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
            @if (request()->has('tag_id'))
                <a href="{{ route('tags.tags', [$model, '#tag-tags']) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('tags.tags', [$model, 'tag_id' => $model->id, '#tag-tags']) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->tags()->count() }})
                </a>
            @endif
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>

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
                        {{ __('tags.hints.tag') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
