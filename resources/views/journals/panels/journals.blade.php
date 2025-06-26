<?php
/**
 * @var \App\Models\Journal $model
 * @var \App\Models\Journal $journal
 */
?>
<div id="journal-journals" class="overflow-x-auto">
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
