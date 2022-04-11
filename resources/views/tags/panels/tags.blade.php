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
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
            @if (request()->has('tag_id'))
                <a href="{{ route('tags.tags', [$model, '#tag-tags']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('tags.tags', [$model, 'tag_id' => $model->id, '#tag-tags']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->tags()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#tag-tags'])
            </div>
        </div>

        <table id="section-sections" class="table table-hover">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('tags.fields.name') }}</th>
                    <th>{{ __('tags.fields.type') }}</th>
                    <th>{{ __('crud.fields.tag') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r = $model->descendants()->with('tag')->has('tag')->filter($filters)->simpleSort($datagridSorter)->paginate() as $model)
                <tr class="{{ $model->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('tags.show', $model->id) }}"></a>
                    </td>
                    <td>
                        @if ($model->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $model->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->tag)
                            {!! $model->tag->tooltipedLink() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('tag-tags')->links() }}
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
                        {{ __('tags.hints.tag') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
