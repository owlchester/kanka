<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('races.show.tabs.races') }}
        </h2>

        <?php  $r = $model->races()->simpleSort($datagridSorter)->with(['characters'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('races.show.tabs.races') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter')

        <table id="races" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('races.fields.name') }}</th>
                @if ($campaign->enabled('characters'))
                    <th>{{ trans('races.fields.characters') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $race)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $race->getImageUrl(40) }}');" title="{{ $race->name }}" href="{{ route('races.show', $race->id) }}"></a>
                    </td>
                    <td>
                        {!! $race->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('characters'))
                    <td>
                        {{ $race->characters()->count() }}
                    </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('races.show', [$race]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
