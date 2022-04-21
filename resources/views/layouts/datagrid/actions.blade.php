@if (empty($actions))
    @php return; @endphp
@endif
<div class="dropdown">
    <a class="dropdown-toggle cursor" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
        <i class="fa fa-ellipsis-v" data-tree="escape"></i>
        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
        @foreach ($actions as $action)
            <li>
                @if ($action === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                    <a href="{{ route($model->url('edit'), $model) }}">
                        <i class="fa fa-pencil"></i>
                        {{ __('crud.edit') }}
                    </a>
                @elseif ($action === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                    <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{!! $model->name !!}"
                       data-target="#delete-confirm" data-delete-target="delete-form-{{ $model->id }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
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
