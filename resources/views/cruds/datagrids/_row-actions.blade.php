<?php /** @var \App\Models\MiscModel $model
 * @var \App\Models\Campaign $campaign
 */
?>


<div class="dropdown" >
    <a role="button" class="cursor-pointer rounded-full w-8 h-8 aspect-square hover:bg-base-200 flex items-center justify-center" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="datagrid-submenu-{{ $model->id }}" aria-label="Quick actions menu" data-tree="escape">
        <i class="fa-regular fa-ellipsis-v" data-tree="escape"></i>
        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
    </a>
    <div class="dropdown-menu hidden" role="menu" id="datagrid-submenu-{{ $model->id }}">
        @foreach ($actions as $action)
            @if (is_null($action))
                <x-dropdowns.divider />
            @elseif (is_array($action))
                <x-dropdowns.item :link="$action['route']" :icon="$action['icon']">
                    {{ __($action['label']) }}
                </x-dropdowns.item>
{{--                <a href="{{ $action['route'] }}" class="p-1 flex items-center gap-2 text-sm text-base-content font-normal">--}}
{{--                    <x-icon class="{{ $action['icon'] }}" />--}}
{{--                </a>--}}
            @endif
        @endforeach
    </div>
</div>
