@php
    $mobileUrl = route($menuItem['route'], [$campaign, isset($menuItem['entity']) ? $entity : $entity->child]);
@endphp
<a href="{{ $mobileUrl }}"
   @class([
       'btn2 px-1.5! gap-1!',
       'min-h-11!' => !$compact,
       'min-h-9! py-1! justify-start! text-left! whitespace-normal' => $compact,
       'btn-ghost' => $active !== $key,
       'bg-base-200! text-base-content!' => $active === $key,
   ])
   @if ($active === $key) aria-current="page" @endif
   @if (!empty($menuItem['ajax'])) data-toggle="dialog" data-url="{{ $mobileUrl }}" @endif>
    <span>{{ strip_tags($menuItem['name']) }}</span>
    @if (!empty($menuItem['count']))
        <span class="text-xs text-neutral-content">({{ $menuItem['count'] }})</span>
    @endif
</a>
