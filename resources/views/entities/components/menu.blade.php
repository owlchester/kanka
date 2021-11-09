@foreach ($model->menuItems() as $section => $menuItems)
    <div class="box box-solid entity-menu-{{ $section }}">
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked entity-menu">
                @foreach ($menuItems as $key => $menuItem)
                    <li class="@if(!empty($active) && $active == $key)active @endif">
                        <a href="{{ route($menuItem['route'], (!isset($menuItem['entity']) ? $model : $model->entity)) }}" title="{{ __($menuItem['name']) }}" @if(\Illuminate\Support\Arr::get($menuItem, 'ajax')) data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route($menuItem['route'], (!isset($menuItem['entity']) ? $model : $model->entity)) }}"@endif>
                            @if (!empty($menuItem['count']))
                                <span class="label label-default pull-right">
                                {{ $menuItem['count'] }}
                            </span>
                            @endif
                            {{ __($menuItem['name']) }}
                        </a>

                        @if(!empty($menuItem['button']))
                            <a href="{{ $menuItem['button']['url'] }}" class="icon" @if(!empty($menuItem['button']['tooltip'])) title="{{ $menuItem['button']['tooltip'] }}" data-toggle="tooltip" @endif>
                                <i class="{{ $menuItem['button']['icon'] }}"></i>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach
