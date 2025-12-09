<a class="name text-link"
   data-toggle="tooltip-ajax"
   data-id="{{ $entity->id }}"
   data-url="{{ route('entities.tooltip', [$campaign, $entity->id]) }}"
   data-theme="entity-tooltip"
@if ($bottom) data-placement="bottom" @endif
   href="{{ $entity->url('show') }}{{ $post() }}">
    @if(isset($slot) && $slot->isNotEmpty()) {!! $slot !!} @else {!! $entity->name !!} @endif</a>
