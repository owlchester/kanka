<?php use \Illuminate\Support\Arr; ?>
@php $modelMenuItems = $model->menuItems(); @endphp
<div class="hidden-xs">
@foreach ($modelMenuItems as $section => $menuItems)
    <div class="box box-solid entity-menu-{{ $section }}">
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked entity-menu">
                @foreach ($menuItems as $key => $menuItem)
                    @php $routeParams = ['campaign' => $campaign, $model];
                    if (isset($menuItem['entity'])) {
                        $routeParams = ['campaign' => $campaign, 'entity' => $model->entity];
                    }
                    @endphp
                    <li class="flex @if(!empty($active) && $active == $key)active @endif">
                        <a
                            href="{{ route($menuItem['route'], $routeParams) }}"
                            title="{{ __($menuItem['name']) }}" @if(Arr::get($menuItem, 'ajax'))
                            data-toggle="ajax-modal" data-target="#large-modal"
                            data-url="{{ route($menuItem['route'], $routeParams) }}"@endif @if (!empty($menuItem['id']))
                            id="{{ $menuItem['id'] }}" @endif
                            class="truncate flex-grow">
                            @if (!empty($menuItem['count']))
                                <span class="label label-default pull-right">
                                {{ $menuItem['count'] }}
                            </span>
                            @endif
                            {{ __($menuItem['name']) }}
                        </a>
                        @if(!empty($menuItem['button']))
                            <a href="{{ $menuItem['button']['url'] }}" class="ml-auto icon" @if(!empty($menuItem['button']['tooltip'])) title="{{ $menuItem['button']['tooltip'] }}" data-toggle="tooltip" @endif>
                                <i class="{{ $menuItem['button']['icon'] }}"></i>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach
</div>

@php $firstBlock = true @endphp
<div class="hidden-md hidden-lg hidden-sm" id="sm-a">
    <div class="form-group">
        <select name="menu-switcher" class="form-control submenu-switcher">
            @foreach ($modelMenuItems as $section => $menuItems)
                @if (!$firstBlock)
                    <option disabled>----</option>
                @endif
                @foreach ($menuItems as $key => $menuItem)
                    @php $routeParams = ['campaign' => $campaign, $model];
                    if (isset($menuItem['entity'])) {
                        $routeParams = ['campaign' => $campaign, 'entity' => $model->entity];
                    }
                    @endphp
                    <option
                            name="{{ $key }}"
                            data-route="{{ route($menuItem['route'], $routeParams) }}"
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
