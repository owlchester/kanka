<?php
/**
 * @var \App\Models\Race $model
 * @var \App\Models\Character $character
 */

$allMembers = true;
$datagridOptions = [
    $campaign,
    $model,
    'init' => 1
];
if (request()->has('race_id')) {
    $datagridOptions['race_id'] = (int) $model->id;
    $allMembers = true;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="flex gap-2 items-center mb-2">
    <h3 class="grow m-0">
        {!! \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')) !!}
    </h3>
    <div>
        <a href="#" class="btn2 btn-sm btn-ghost" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>

        @if (request()->has('race_id'))
            <a href="{{ route('races.show', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('races.show', [$campaign, $model, 'race_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->characters()->count() }})
            </a>
        @endif
        @can('update', $model)
            <a href="{{ route('races.members.create', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('races.members.create', [$campaign, $model]) }}">
                <x-icon class="plus"></x-icon>
                <span class="hidden md:inline">{{ __('crud.add') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="race-characters">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('races.characters', $datagridOptions)])
    </div>
</div>



@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('races.characters.helpers.' . ($allMembers ? 'all_' : null) . 'characters')
        ]
    ])
@endsection
