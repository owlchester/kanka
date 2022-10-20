<div class="box box-solid" id="organisation-suborganisations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('organisations.show.tabs.organisations') }}
        </h3>

        <div class="box-tools">
            @if (request()->has('parent_id'))
                <a href="{{ route('organisations.organisations', [$model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('organisations.organisations', [$model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->organisations()->count() }})
                </a>
            @endif
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

