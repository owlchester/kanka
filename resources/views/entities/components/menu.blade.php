<?php use \Illuminate\Support\Arr;
$modelMenuItems = \App\Facades\Submenu::campaign($campaign)->model($model)->entity($entity)->items();
?>
<div class="hidden md:flex flex-col gap-5">
@foreach ($modelMenuItems as $section => $menuItems)
    <x-box css="entity-menu{{ $section }}" :padding="0">
        <x-menu>
            @foreach ($menuItems as $key => $menuItem)
                @if (Arr::has($menuItem, 'perm'))
                    @cannot($menuItem['perm'], [$model->entity, $campaign])
                        @continue
                    @endcannot
                @endif
                <x-menu.element
                    :active="!empty($active) && $active == $key"
                    :route="route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $model : $model->entity)])"
                    :badge="$menuItem['count'] ?? 0"
                    :button="$menuItem['button'] ?? null"
                    :ajax="Arr::get($menuItem, 'ajax') ? route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $model : $model->entity)]) : null"
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
<div class="md:hidden" id="sm-a">
    <select name="menu-switcher" class="w-full submenu-switcher">
        @foreach ($modelMenuItems as $section => $menuItems)
            @if (!$firstBlock)
                <option disabled>----</option>
            @endif
            @foreach ($menuItems as $key => $menuItem)
                <option
                        name="{{ $key }}"
                        data-route="{{ route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $model : $model->entity)]) }}"
                        @if($key == $active) selected="selected" @endif
                        @if(Arr::get($menuItem, 'ajax')) data-toggle="dialog" data-target="primary-dialog" data-url="{{ route($menuItem['route'], [$campaign, (!isset($menuItem['entity']) ? $model : $model->entity)]) }}" @endif
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
