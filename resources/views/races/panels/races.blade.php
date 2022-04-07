<div class="box box-solid" id="race-races">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('races.show.tabs.races') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->races()->simpleSort($datagridSorter)->with(['characters'])->paginate(); ?>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#race-races'])
            </div>
        </div>

        <table id="races" class="table table-hover">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('races.fields.name') }}</th>
                    <th>{{ __('races.fields.type') }}</th>
                    @if ($campaign->enabled('characters'))
                        <th>{{ __('races.fields.characters') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $race)
                <tr class="{{ $race->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $race->getImageUrl(40) }}');" title="{{ $race->name }}" href="{{ route('races.show', $race->id) }}"></a>
                    </td>
                    <td>
                        @if ($race->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $race->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $race->type }}
                    </td>
                    @if ($campaign->enabled('characters'))
                    <td>
                        {{ $race->characters()->count() }}
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            </thead>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('race-races')->links() }}
        </div>
    @endif
</div>
