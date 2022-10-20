<div class="box box-solid" id="race-races">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('races.show.tabs.races') }}
        </h3>
        <div class="box-tools">
            @if (request()->has('parent'))
                <a href="{{ route('races.races', [$model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('races.races', [$model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->races()->count() }})
                </a>
            @endif
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
