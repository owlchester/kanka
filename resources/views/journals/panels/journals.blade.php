<?php
/**
 * @var \App\Models\Journal $model
 * @var \App\Models\Journal $journal
 */
?>
<div class="box box-solid" id="journal-journals">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('journals.show.tabs.journals') }}
        </h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
            @if (request()->has('parent_id'))
                <a href="{{ route('journals.journals', [$model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allJournals()->count() }})
                </a>
            @else
                <a href="{{ route('journals.journals', [$model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->journals()->count() }})
                </a>
            @endif
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('journals.helpers.journals')
        ]
    ])
@endsection
