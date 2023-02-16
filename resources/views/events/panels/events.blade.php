<div class="box box-solid" id="event-events">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('events.fields.events') }}
        </h3>
        <div class="box-tools">
            @if (request()->has('parent_id'))
                <a href="{{ route('events.events', [$campaign, $model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('events.events', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->events()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
