<?php
/** @var \App\Models\Tag $model*/
$filters = [];
if (request()->has('tag_id')) {
    $filters['tag_id'] = request()->get('tag_id');
}
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('tags.show.tabs.children') }}
        </h2>
        <p class="help-block export-hidden">
            {{ trans('tags.hints.tag') }}
        </p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">
                @if (request()->has('tag_id'))
                    <a href="{{ route('tags.tags', $model) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                    </a>
                @else
                    <a href="{{ route('tags.tags', [$model, 'tag_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->tags()->count() }})
                    </a>
                @endif
            </div>
        </div>

        <table id="section-sections" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('tags.fields.name') }}</th>
                <th>{{ trans('tags.fields.type') }}</th>
                <th>{{ trans('crud.fields.tag') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r = $model->descendants()->with('tag')->has('tag')->filter($filters)->simpleSort($datagridSorter)->paginate() as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('tags.show', $model->id) }}"></a>
                    </td>
                    <td>
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

        {{ $r->links() }}
    </div>
</div>
