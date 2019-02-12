<?php
/** @var \App\Models\Tag $model*/
$filters = [];
if (request()->has('tag_id')) {
    $filters['tag_id'] = request()->get('tag_id');
}
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('tags.show.tabs.children') }}
        </h2>
        <p class="help-block export-hidden">
            @if (request()->has('tag_id'))
                <a href="{{ route('tags.tags', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->acl()->count() }})
                </a>
            @else
                <a href="{{ route('tags.tags', [$model, 'tag_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->tags()->acl()->count() }})
                </a>
            @endif
            {{ trans('tags.hints.tag') }}
        </p>
        <table id="section-sections" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('tags.fields.name') }}</th>
                <th>{{ trans('tags.fields.type') }}</th>
                <th>{{ trans('crud.fields.tag') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r = $model->descendants()->with('tag')->acl()->filter($filters)->orderBy('name', 'ASC')->paginate() as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('tags.show', $model->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('tags.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->tag)
                            <a href="{{ route('tags.show', $model->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tooltip() }}">{{ $model->tag->name }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>