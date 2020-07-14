<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.maps') }}
        </h2>

        <?php  $r = $model->maps()->orderBy('name', 'ASC')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.maps') }}</p>
        <table id="maps" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('maps.fields.name') }}</th>
                <th>{{ trans('maps.fields.type') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $map)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $map->getImageUrl(40) }}');" title="{{ $map->name }}" href="{{ route('maps.show', $map->id) }}"></a>
                    </td>
                    <td>
                        {!! $map->tooltipedLink() !!}
                    </td>
                    <td>{{ $map->type }}</td>
                    <td class="text-right">
                        <a href="{{ route('maps.show', [$map]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                        <a href="{{ route('maps.explore', $map) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-map"></i> {{ __('maps.actions.explore') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
