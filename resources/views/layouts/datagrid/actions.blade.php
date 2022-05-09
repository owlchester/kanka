@if (empty($actions))
    @php return; @endphp
@endif
<div class="dropdown">
    <a class="dropdown-toggle cursor" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
        <i class="fa-solid fa-ellipsis-v" data-tree="escape"></i>
        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
        @foreach ($actions as $action)
            <li>
                @if ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                    <a href="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams() : $model) }}">
                        <i class="fa-solid fa-pencil"></i>
                        {{ __('crud.edit') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT_AJAX)
                    <a href="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams() : $model) }}"
                       data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route($model->url('edit'), method_exists($model, 'routeParams') ? $model->routeParams() : $model) }}"
                    >
                        <i class="fa-solid fa-pencil"></i>
                        {{ __('crud.edit') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                    <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{!! method_exists($model, 'deleteName') ? $model->deleteName() : $model->name !!}"
                       data-target="#delete-confirm" data-delete-target="delete-form-{{ $model->id }}"
                       {!! method_exists($model, 'actionDeleteConfirmOptions') ? $model->actionDeleteConfirmOptions() : null !!}
                    >
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        {{ __('crud.remove') }}
                    </a>
                @elseif (is_array($action))
                    @if (\Illuminate\Support\Arr::get($action, 'type') === 'ajax-modal')
                        <a href="{{ route($action['route'], $model) }}"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route($action['route'], $model) }}">
                            @if (!empty($action['icon']))
                                <i class="{{ $action['icon'] }}" aria-hidden="true"></i>
                            @endif
                            {{ __($action['label']) }}
                        </a>
                        @continue
                    @endif
                    <a href="{{ route($action['route'], $model) }}" class="dropdown-item">
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
