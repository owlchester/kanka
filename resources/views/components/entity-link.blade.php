<a class="name"
   data-toggle="tooltip-ajax"
   data-id="{{ $entity->id }}"
   data-url="{{ route('entities.tooltip', [$campaign, $entity->id]) }}"
   data-theme="entity-tooltip"
@if ($bottom) data-placement="bottom" @endif
   href="{{ $entity->url('show') }}{{ $post() }}">{!! $name() !!}</a>
