<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.locations') }}
        </h2>

        <p class="help-block">{{ trans('locations.helpers.descendants') }}</p>

        <?php $r = $model->descendants()->with('parent')->acl()->orderBy('name', 'ASC')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.locations') }}</p>
        <table id="locations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('locations.fields.name') }}</th>
                <th>{{ trans('locations.fields.type') }}</th>
                <th>{{ trans('crud.fields.location') }}</th>
                <th>&nbsp;</th>
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

        {{ $r->links() }}
    </div>
</div>