<?php
$datagridOptions = [
    $campaign,
    $model,
    'init' => 1
];
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="flex gap-2 items-center">
    <h3 class="grow">
        {!! \App\Facades\Module::plural(config('entities.ids.item'), __('entities.items')) !!}
    </h3>
    <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
        <x-icon class="question" /> {{ __('crud.actions.help') }}
    </a>
</div>
<div class="item-subitems" id="subitems">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('items.items', $datagridOptions)])
    </div>
</div>

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('items.hints.items')
        ]
    ])
@endsection
