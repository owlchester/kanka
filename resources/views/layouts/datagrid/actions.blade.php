@if (empty($actions))
    @php return; @endphp
@endif
<div class="dropdown">
    <a role="button" class="cursor-pointer w-8 h-8 rounded-full hover:bg-base-300 flex items-center justify-center align-middle" data-dropdown aria-expanded="false" data-placement="right" data-tree="escape" aria-haspopup="menu" aria-controls="actions-submenu" aria-label="{{ __('crud.actions.actions') }}">
        <i class="fa-regular fa-ellipsis-v " data-tree="escape"></i>
        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
    </a>
    <div class="dropdown-menu hidden" role="menu" id="actions-submenu">
        @foreach ($actions as $action)
                @if ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                    <x-dropdowns.item
                        :link="route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + ['campaign' => $campaign]) : [$campaign, $model])"
                        icon="pencil">
                        {{ __('crud.edit') }}
                    </x-dropdowns.item>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_COPY)
                    <x-dropdowns.item
                        :link="route($model->url('create'), method_exists($model, 'routeCopyParams') ? $model->routeCopyParams($params + ['campaign' => $campaign]) : [$campaign, $model])"
                        icon="copy">
                        {{ __('crud.actions.copy') }}
                    </x-dropdowns.item>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT_DIALOG)
                    <x-dropdowns.item
                        :link="route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + ['campaign' => $campaign]) : ['campaign' => $campaign, $model])"
                        :dialog="route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + [$campaign]) : [$campaign, $model])"
                        icon="pencil">
                        {{ __('crud.edit') }}
                    </x-dropdowns.item>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                <x-dropdowns.item
                    link="#"
                    css="text-error hover:bg-error hover:text-error-content"
                    :dialog="route('confirm-delete', [$campaign, 'route' => route($model->url('destroy'), method_exists($model, 'routeParams') ? $model->routeParams(['campaign' => $campaign] + $params) : [$campaign, $model]), 'name' => (method_exists($model, 'deleteName') ? $model->deleteName() : $model->name), 'permanent' => true] + (method_exists($model, 'actionDeleteConfirmOptions') ? $model->actionDeleteConfirmOptions() : []))"
                    icon="trash">
                    {{ __('crud.remove') }}
                </x-dropdowns.item>
                @elseif (is_array($action))
                    @if (\Illuminate\Support\Arr::get($action, 'type') === 'dialog-ajax')
                        <x-dropdowns.item
                            :css="$action['css'] ?? ''"
                            :link="route($action['route'], [$campaign, $model])"
                            :dialog="route($action['route'], [$campaign, $model])"
                            :icon="$action['icon']">
                            {{ __($action['label']) }}
                        </x-dropdowns.item>
                        @continue
                    @endif

                    <x-dropdowns.item
                        :link="route($action['route'], (method_exists($model, 'routeParams') ? $model->routeParams($params) : [$campaign, $model]))"
                        :icon="$action['icon']">
                        {{ __($action['label']) }}
                    </x-dropdowns.item>
                @endif

        @endforeach
    </div>
</div>
