<div class="box box-solid" id="timeline-timelines">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('timelines.fields.timelines') }}
        </h2>

        <?php  $r = $model->descendants()->with('entity')->simpleSort($datagridSorter)->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('timelines.show.tabs.timelines') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#timeline-timelines'])

        <table id="timelines" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('timelines.fields.name') }}</th>
                <th>{{ __('crud.fields.type') }}</th>
                <th>{{ __('timelines.fields.timeline') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $timeline)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $timeline->getImageUrl(40) }}');" title="{{ $timeline->name }}" href="{{ route('timelines.show', $timeline->id) }}"></a>
                    </td>
                    <td>
                        {!! $timeline->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $timeline->type }}
                    </td>
                    <td>
                        @if ($timeline->timeline)
                        {!! $timeline->timeline->tooltipedLink() !!}
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('timelines.show', [$timeline]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('timeline-timelines')->links() }}
    </div>
</div>
