<?php
/**
 * @var \App\Models\Race $model
 * @var \App\Models\Character $character
 */

$allMembers = false;
$datagridOptions = [
    $campaign,
    $entity->child,
    'init' => 1
];
if (request()->get('m') == \App\Enums\Descendants::All->value || (!request()->has('m') && $campaign->defaultDescendantsMode() === \App\Enums\Descendants::All)) {
    $datagridOptions['m'] = \App\Enums\Descendants::All;
    $allMembers = true;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="flex gap-2 items-center">
    <h3 class="grow">
        {!! \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')) !!}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $entity->child->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $entity->child->characters()->count() }})
            </a>
        @endif
        @can('update', $entity)
            <a href="{{ route('races.members.create', [$campaign, $entity->child]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('races.members.create', [$campaign, $entity->child]) }}">
                <x-icon class="plus" />
                <span class="hidden xl:inline">{{ __('crud.add') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="race-characters">
    <div id="datagrid-parent" class="overflow-auto table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('races.characters', $datagridOptions)])
    </div>
</div>
