<div class="box box-solid" id="family-families">
    <div class="box-header">
        <h3 class="box-title">
            {{ trans('families.show.tabs.families') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">{{ trans('families.helpers.descendants') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#family-families'])

        <?php $r = $model->descendants()->simpleSort($datagridSorter)->with('parent')->paginate(); ?>

        <table id="families" class="table table-hover margin-top ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('families.fields.name') }}</th>
                <th>{{ trans('crud.fields.family') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ trans('crud.fields.location') }}</th>
                @endif
            </tr>
            @foreach ($r as $family)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $family->getImageUrl(40) }}');" title="{{ $family->name }}" href="{{ route('families.show', $family->id) }}"></a>
                    </td>
                    <td>
                        {!! $family->tooltipedLink() !!}
                    </td>
                    <td>
                        @if ($family->parent)
                            {!! $family->parent->tooltipedLink() !!}
                        @endif
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($family->location)
                            {!! $family->location->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('family-families')->links() }}
    </div>
</div>
