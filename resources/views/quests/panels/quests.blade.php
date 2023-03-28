<?php
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('parent_id')) {
    $datagridOptions['parent_id'] = (int) request()->get('parent_id');
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="box box-solid quest-subquests" id="subquests">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('quests.fields.quests') }}</h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
            </a>
            @if (request()->has('parent_id'))
                <a href="{{ route('quests.quests', [$model]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('quests.quests', [$model, 'parent_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->quests()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('quests.quests', $datagridOptions)])
    </div>
</div>

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('quests.hints.quests')
        ]
    ])
@endsection
