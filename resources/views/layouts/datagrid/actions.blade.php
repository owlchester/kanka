@if (empty($actions))
    @php return; @endphp
@endif
<div class="dropdown">
    <a role="button" class="dropdown-toggle cursor-pointer w-8 h-8 rounded-full hover:bg-base-200 flex items-center justify-center align-middle" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape" aria-haspopup="menu" aria-controls="actions-submenu" aria-label="{{ __('crud.actions.actions') }}">
        <i class="fa-solid fa-ellipsis-v " data-tree="escape"></i>
        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu" id="actions-submenu">
        @foreach ($actions as $action)
            <li>
                @if ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                    <a href="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + ['campaign' => $campaign]) : [$campaign, $model]) }}">
                        <x-icon class="pencil"></x-icon>
                        {{ __('crud.edit') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_COPY)
                    <a href="{{ route($model->url('create'), method_exists($model, 'routeCopyParams') ? $model->routeCopyParams($params + ['campaign' => $campaign]) : [$campaign, $model]) }}">
                        <x-icon class="fa-solid fa-copy"></x-icon>
                        {{ __('crud.actions.copy') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT_DIALOG)
                    <a href="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + ['campaign' => $campaign]) : ['campaign' => $campaign, $model]) }}"
                       data-toggle="dialog" data-target="primary-dialog"
                       data-url="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams($params + [$campaign]) : [$campaign, $model]) }}"
                    >
                        <x-icon class="pencil"></x-icon>
                        {{ __('crud.edit') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                    <a href="#" class="text-red"
                       data-toggle="dialog"
                       data-target="primary-dialog"
                       data-url="{{ route('confirm-delete', [$campaign, 'route' => route($model->url('destroy'), method_exists($model, 'routeParams') ? $model->routeParams(['campaign' => $campaign] + $params) : [$campaign, $model]), 'name' => (method_exists($model, 'deleteName') ? $model->deleteName() : $model->name), 'permanent' => true] + (method_exists($model, 'actionDeleteConfirmOptions') ? $model->actionDeleteConfirmOptions() : [])) }}"
                    >
                        <x-icon class="trash"></x-icon>
                        {{ __('crud.remove') }}
                    </a>
                @elseif (is_array($action))
                    @if (\Illuminate\Support\Arr::get($action, 'type') === 'dialog-ajax')
                        <a href="{{ route($action['route'], [$campaign, $model]) }}"
                           data-toggle="dialog-ajax" data-target="{{ $action['target'] }}" data-url="{{ route($action['route'], [$campaign, $model]) }}">
                            @if (!empty($action['icon']))
                                <i class="{{ $action['icon'] }}" aria-hidden="true"></i>
                            @endif
                            {{ __($action['label']) }}
                        </a>
                        @continue
                    @endif
                    <a href="{{ route($action['route'], (method_exists($model, 'routeParams') ? $model->routeParams($params) : [$campaign, $model])) }}" class="dropdown-item">
                        @if (!empty($action['icon']))
                            <i class="{{ $action['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ __($action['label']) }}
                    </a>
                @endif
            </li>

        @endforeach
    </ul>
</div>
