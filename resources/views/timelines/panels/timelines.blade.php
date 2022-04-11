<div class="box box-solid" id="timeline-timelines">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('timelines.fields.timelines') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->descendants()->with('entity')->simpleSort($datagridSorter)->paginate(); ?>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#timeline-timelines'])
            </div>
        </div>

        <table id="timelines" class="table table-hover ">
            <thead><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('timelines.fields.name') }}</th>
                <th>{{ __('crud.fields.type') }}</th>
                <th>{{ __('timelines.fields.timeline') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($r as $timeline)
                <tr class="{{ $timeline->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $timeline->getImageUrl(40) }}');" title="{{ $timeline->name }}" href="{{ route('timelines.show', $timeline->id) }}"></a>
                    </td>
                    <td>
                        @if ($timeline->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('timeline-timelines')->links() }}
        </div>
    @endif
</div>
