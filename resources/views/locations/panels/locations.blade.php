<?php
$filters = [];
if (request()->has('parent_location_id')) {
    $filters['parent_location_id'] = request()->get('parent_location_id');
}
?><div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.locations') }}
        </h2>

        <p class="help-block">{{ trans('locations.helpers.descendants') }}</p>

        <p class="export-hidden">@if (request()->has('parent_location_id'))
            <a href="{{ route('locations.locations', $model) }}" class="btn btn-default">
                <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('locations.locations', [$model, 'parent_location_id' => $model->id]) }}" class="btn btn-default">
                <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->locations()->count() }})
            </a>
        @endif
        </p>

        <?php $r = $model->descendants()->filter($filters)->with('parent')->acl()->orderBy('name', 'ASC')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.locations') }}</p>
        <table id="locations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('locations.fields.name') }}</th>
                <th>{{ trans('locations.fields.type') }}</th>
                <th>{{ trans('crud.fields.location') }}</th>
            </tr>
            @foreach ($r as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('locations.show', $model->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('locations.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->parent)
                            <a href="{{ route('locations.show', $model->parent->id) }}" data-toggle="tooltip" title="{{ $model->parent->tooltip() }}">{{ $model->parent->name }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->appends($filters)->links() }}
    </div>
</div>