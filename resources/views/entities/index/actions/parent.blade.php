<?php /** @var \App\Models\Entity $parent */?>
@if ($parent->parent)
    <a href="{{ route($route . '.index', [$campaign, 'parent_id' => $parent->parent->id]) }}" class="btn2">
<x-icon class="fa-regular fa-arrow-left"></x-icon>
        <span class="hidden lg:inline">
            {!! $parent->parent->name !!}
        </span>
    </a>
@else

    <a href="{{ route($route . '.index', [$campaign]) }}" class="btn2">
        <x-icon class="fa-regular fa-arrow-left"></x-icon>
        <span class="hidden lg:inline">
            {{ __('crud.actions.back') }}
        </span>
    </a>
@endif

