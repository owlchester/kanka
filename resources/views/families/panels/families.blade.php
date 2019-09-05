<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('families.show.tabs.families') }}
        </h2>

        <p class="help-block">{{ trans('families.helpers.descendants') }}</p>

        <?php $r = $model->descendants()->with('parent')->orderBy('name', 'ASC')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('families.show.tabs.families') }}</p>
        <table id="families" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('families.fields.name') }}</th>
                <th>{{ trans('crud.fields.family') }}</th>
                <th>{{ trans('crud.fields.location') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $family)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $family->getImageUrl(true) }}');" title="{{ $family->name }}" href="{{ route('families.show', $family->id) }}"></a>
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

        {{ $r->links() }}
    </div>
</div>