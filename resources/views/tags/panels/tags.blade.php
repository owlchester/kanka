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
            <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
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
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('tags.hints.tag')
        ]
    ])
@endsection
