<?php /** @var \App\Models\Family $family */?>
<div class="box box-solid" id="family-families">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('families.show.tabs.families') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">{{ __('families.helpers.descendants') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#family-families'])

        <?php $r = $model->descendants()->simpleSort($datagridSorter)->with('parent')->paginate(); ?>

        <table id="families" class="table table-hover margin-top ">
            <thead><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('families.fields.name') }}</th>
                <th>{{ __('crud.fields.family') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ __('crud.fields.location') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($r as $family)
                <tr class="{{ $family->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $family->getImageUrl(40) }}');" title="{{ $family->name }}" href="{{ route('families.show', $family->id) }}"></a>
                    </td>
                    <td>
                        @if ($family->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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
