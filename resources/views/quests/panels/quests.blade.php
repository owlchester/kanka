<?php
$datagridOptions = [
    $campaign,
    $model,
    'init' => 1
];
if (request()->has('parent_id')) {
    $datagridOptions['parent_id'] = (int) request()->get('parent_id');
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>
<div class="flex gap-2 items-center mb-2">
    <h3 class="grow m-0">
        {!! \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests')) !!}
    </h3>
    <div class="flex gap-2 flex-wrap">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('parent_id'))
            <a href="{{ route('quests.show', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('quests.show', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->quests()->count() }})
            </a>
        @endif
    </div>
</div>
<div class="quest-subquests" id="subquests">
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
