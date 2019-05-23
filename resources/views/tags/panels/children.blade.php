<?php
/** @var \App\Models\Tag $model*/
$filters = [];
$r = null;
if (request()->has('tag_id')) {
    $filters['tag_id'] = request()->get('tag_id');
    $r = $model->entities()->acl()->orderBy('name', 'ASC')->paginate();
} else {
    $r = $model->allChildren()->acl()->orderBy('name', 'ASC')->paginate();
}
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('tags.show.tabs.children') }}
        </h2>

        <p class="help-block export-hidden">
            @if (request()->has('tag_id'))
                <a href="{{ route('tags.children', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allChildren()->acl()->count() }})
                </a>
            @else
                <a href="{{ route('tags.children', [$model, 'tag_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->entities()->acl()->count() }})
                </a>
            @endif
                {{ trans('tags.hints.children') }}
        </p>
        <table id="section-children" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('crud.fields.name') }}</th>
                <th>{{ trans('crud.fields.entity') }}</th>
            </tr>
            @foreach ($r as $model)
                <tr>
                    @if ($model->child)
                        <td>
                            <a class="entity-image" style="background-image: url('{{ $model->child->getImageUrl(true) }}');" title="{{ $model->child->name }}" href="{{ route($model->pluralType() . '.show', $model->child->id) }}"></a>
                        </td>
                        <td>
                            <a href="{{ route($model->pluralType() . '.show', $model->child->id) }}" data-toggle="tooltip" title="{{ $model->tooltipWithName() }}" data-html="true">
                                {{ $model->child->name }}
                            </a>
                        </td>
                        <td>
                            {{ trans('entities.' . $model->pluralType()) }}
                        </td>
                    @else
                        <td colspan="3">
                            {{ trans('crud.is_private') }}
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>