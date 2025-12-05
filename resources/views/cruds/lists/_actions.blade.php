@foreach ($actions as $action)
    @if (empty($action['policy']) || (auth()->check() && auth()->user()->can($action['policy'], $model)))
        <a href="{{ $action['route'] }}" class="btn2 btn-{{ $action['class'] }}">
            {!! $action['label'] !!}
        </a>
    @endif
@endforeach
