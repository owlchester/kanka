<?php /** @var \App\Models\Family $family */?>
<div class="box box-solid" id="family-families">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('families.show.tabs.families') }}
        </h3>
        <div class="box-tools">
            @if (request()->has('parent_id'))
                <a href="{{ route('families.families', [$model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('families.families', [$model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->families()->count() }})
                </a>
            @endif
        </div>
    </div>
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    </div>
</div>
