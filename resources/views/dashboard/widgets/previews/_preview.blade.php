<div x-data="{open: false}">
    <div :class="{ 'preview max-h-52': !open, 'overflow-hidden relative': true }" id="widget-preview-body-{{ $widget->id }}">
        {!! $slot !!}
        @if ($entity->hasEntry())
        <div class="entity-content">
            {!! $entity->parsedEntry() !!}
        </div>
        @endif

        @include('dashboard.widgets.previews._members')
        @include('dashboard.widgets.previews._relations')
        @include('dashboard.widgets.previews._attributes')
        <div class="absolute w-full bottom-0 h-52 gradient-to-base-100" x-show="!open" x-cloak></div>
    </div>
    <span role="button" class="inline-block w-full text-center"
       id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}" data-toggle="tooltip" data-title="{{ __('Click to toggle') }}" @click="open = !open">
        <x-icon class="fa-solid fa-chevron-down" show="!open" x-cloak   />
        <x-icon class="fa-solid fa-chevron-up" show="open" x-cloak />
        <span class="sr-only">{{ __('Click to toggle') }}</span>
    </span>
</div>
