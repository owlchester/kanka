<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.maps') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->maps()->orderBy('name', 'ASC')->paginate(); ?>

        <table id="maps" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('maps.fields.name') }}</th>
                <th>{{ __('maps.fields.type') }}</th>
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
                            <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ __('crud.view') }}
                        </a>
                        <a href="{{ route('maps.explore', $map) }}" class="btn btn-xs btn-primary">
                            <i class="fa-solid fa-map"></i> {{ __('maps.actions.explore') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->links() }}
        </div>
    @endif
</div>
