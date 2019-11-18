<?php
/** 
 * @var \App\Models\Location $model
 * @var \App\Models\Family $family
 */
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.families') }}
        </h2>


        <p class="help-block export-hidden">
            {{ trans('locations.helpers.families') }}
        </p>

        @include('cruds.datagrids.sorters.simple-sorter')

        <?php  $r = $model->families()->simpleSort($datagridSorter)->with(['location', 'family', 'entity', 'entity.tags'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.characters') }}</p>
        <table id="characters" class="table table-hover margin-top {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('families.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                    <th>{{ trans('crud.fields.location') }}</th>
                @endif
                <th>{{ trans('crud.fields.family') }}</th>
                <th>{{ trans('crud.fields.type') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $family)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $family->getImageUrl(true) }}');" title="{{ $family->name }}" href="{{ route('characters.show', $family->id) }}"></a>
                    </td>
                    <td>
                        {!! $family->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td>
                            @if ($family->location)
                                {!! $family->location->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    <td>
                        @if ($family->family)
                            {!! $family->family->tooltipedLink() !!}
                        @endif
                    </td>
                    <td>{{ $family->type }}</td>
                    <td class="text-right">
                        <a href="{{ route('characters.show', ['id' => $family->id]) }}" class="btn btn-xs btn-primary">
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