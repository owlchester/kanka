@if (!isset($exporting))
    <div class="box box-solid">
        <div class="box-header with-border visible-xs">
            <h3 class="box-title">
                {{ __('crud.tabs.menu') }}
            </h3>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="@if(empty($active))active @endif">
                    <a href="{{ route($name . '.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                @foreach ($model->menuItems() as $key => $menuItem)
                    <li class="@if(!empty($active) && $active == $key)active @endif">
                        <a href="{{ route($menuItem['route'], (!isset($menuItem['entity']) ? $model : $model->entity)) }}" title="{{ __($menuItem['name']) }}">
                            {{ __($menuItem['name']) }}
                            @if (!empty($menuItem['count']))
                            <span class="label label-default pull-right">
                                {{ $menuItem['count'] }}
                            </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif