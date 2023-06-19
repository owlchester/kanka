<?php use \Illuminate\Support\Arr; ?>
@php $modelMenuItems = $model->menuItems(); @endphp
<div class="hidden-xs">
@foreach ($modelMenuItems as $section => $menuItems)
    <x-box css="entity-menu{{ $section }}" :padding="0">
        <x-menu>
            @foreach ($menuItems as $key => $menuItem)
                <x-menu.element
                    :active="!empty($active) && $active == $key"
                    :route="route($menuItem['route'], (!isset($menuItem['entity']) ? $model : $model->entity))"
                    :badge="$menuItem['count'] ?? 0"
                    :button="$menuItem['button'] ?? null"
                    :ajax="Arr::get($menuItem, 'ajax') ? route($menuItem['route'], (!isset($menuItem['entity']) ? $model : $model->entity)) : null"
                    :id="$menuItem['id'] ?? null"
                >
                    {!! __($menuItem['name']) !!}
                </x-menu.element>

            @endforeach
        </x-menu>
    </x-box>
@endforeach
</div>

@php $firstBlock = true @endphp
<div class="hidden-md hidden-lg hidden-sm" id="sm-a">
    <div class="mb-2">
        <select name="menu-switcher" class="form-control submenu-switcher">
            @foreach ($modelMenuItems as $section => $menuItems)
                @if (!$firstBlock)
                    <option disabled>----</option>
                @endif
                @foreach ($menuItems as $key => $menuItem)
                    <option
                            name="{{ $key }}"
                            data-route="{{ route($menuItem['route'], [(!isset($menuItem['entity']) ? $model : $model->entity)]) }}"
                            @if($key == $active) selected="selected" @endif
                            @if(Arr::get($menuItem, 'ajax')) data-toggle="ajax-modal" data-target="#large-modal" @endif
                    >
                        {{ __($menuItem['name']) }}
                        @if (!empty($menuItem['count']))
                            ({{ $menuItem['count'] }})
                        @endif
                    </option>
                @endforeach
                @php $firstBlock = false @endphp
            @endforeach
        </select>
    </div>
</div>
